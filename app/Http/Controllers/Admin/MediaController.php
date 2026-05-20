<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Services\MediaService;
use App\Services\CmsCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    protected $mediaService;
    protected $cacheService;
    
    public function __construct(MediaService $mediaService, CmsCacheService $cacheService)
    {
        $this->mediaService = $mediaService;
        $this->cacheService = $cacheService;
    }

    /**
     * Display the media library
     */
    public function index(Request $request)
    {
        $query = Attachment::with('uploader')->where('is_active', true);
        
        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            if ($request->type === 'images') {
                $query->where('mime_type', 'like', 'image/%');
            } elseif ($request->type === 'documents') {
                $query->whereIn('mime_type', [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ]);
            } elseif ($request->type === 'videos') {
                $query->where('mime_type', 'like', 'video/%');
            } elseif ($request->type === 'audio') {
                $query->where('mime_type', 'like', 'audio/%');
            }
        }
        
        // Filter by folder
        if ($request->has('folder') && $request->folder !== 'all') {
            $query->where('folder', $request->folder);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('caption', 'like', "%{$search}%");
            });
        }
        
        // Date filtering
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Size filtering
        if ($request->has('size_min') && $request->size_min) {
            $query->where('size', '>=', $request->size_min * 1024); // Convert KB to bytes
        }
        if ($request->has('size_max') && $request->size_max) {
            $query->where('size', '<=', $request->size_max * 1024);
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);
        
        // View mode
        $viewMode = $request->get('view', 'grid');
        $perPage = $viewMode === 'list' ? 50 : 24;
        
        $media = $query->paginate($perPage)->withQueryString();
        $folders = $this->mediaService->getFolders();
        $stats = $this->mediaService->getStats();
        
        return view('admin.media.index', compact('media', 'folders', 'stats', 'viewMode'));
    }

    /**
     * Store uploaded files
     */
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:' . (config('cms.max_upload_size', 10240)), // Default 10MB
            'folder' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255'
        ]);
        
        $uploadedFiles = [];
        $errors = [];
        
        foreach ($request->file('files') as $file) {
            try {
                $attachment = $this->mediaService->uploadFile($file, [
                    'folder' => $request->folder ?: 'uploads/' . date('Y/m'),
                    'alt_text' => $request->alt_text,
                    'title' => $request->title,
                    'uploaded_by' => auth()->id()
                ]);
                
                $uploadedFiles[] = $attachment;
                
                // Clear attachment cache
                $this->cacheService->clearAttachmentCaches($attachment->id);
                
            } catch (\Exception $e) {
                $errors[] = 'Failed to upload ' . $file->getClientOriginalName() . ': ' . $e->getMessage();
            }
        }
        
        $response = [
            'success' => count($uploadedFiles) > 0,
            'message' => count($uploadedFiles) . ' file(s) uploaded successfully',
            'files' => $uploadedFiles->map(function($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->original_name,
                    'url' => $file->url,
                    'thumbnail' => $file->thumbnail_url,
                    'size' => $file->file_size,
                    'type' => $file->file_type,
                    'mime_type' => $file->mime_type
                ];
            })
        ];
        
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        
        return response()->json($response);
    }

    /**
     * Show media details
     */
    public function show($id)
    {
        $attachment = Attachment::with(['uploader', 'pages', 'sections'])->findOrFail($id);
        
        return view('admin.media.show', compact('attachment'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $attachment = Attachment::with('uploader')->findOrFail($id);
        $folders = $this->mediaService->getFolders();
        
        return view('admin.media.edit', compact('attachment', 'folders'));
    }

    /**
     * Update media metadata
     */
    public function update(Request $request, $id)
    {
        $attachment = Attachment::findOrFail($id);
        
        $request->validate([
            'original_name' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'folder' => 'nullable|string|max:255'
        ]);
        
        try {
            $attachment->update($request->only([
                'original_name', 'alt_text', 'title', 'caption', 'folder'
            ]));
            
            // Clear attachment cache
            $this->cacheService->clearAttachmentCaches($attachment->id);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File updated successfully',
                    'file' => $attachment
                ]);
            }
            
            return redirect()
                ->route('admin.media.index')
                ->with('flash_message', [
                    'title' => 'Success!',
                    'message' => 'File updated successfully',
                    'type' => 'success'
                ]);
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update file: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('flash_message', [
                'title' => 'Error!',
                'message' => 'Failed to update file: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    /**
     * Delete media file
     */
    public function destroy($id)
    {
        try {
            $attachment = Attachment::findOrFail($id);
            
            // Check if file is being used
            $usage = $this->getFileUsage($attachment);
            if ($usage['total_usage'] > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete file that is currently in use',
                    'usage' => $usage
                ], 422);
            }
            
            // Delete the file
            $this->mediaService->deleteFile($attachment);
            
            // Clear attachment cache
            $this->cacheService->clearAttachmentCaches($attachment->id);
            
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file usage information
     */
    public function getUsage($id)
    {
        $attachment = Attachment::findOrFail($id);
        $usage = $this->getFileUsage($attachment);
        
        return response()->json($usage);
    }

    /**
     * Bulk operations
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,move,update_alt_text',
            'files' => 'required|array',
            'files.*' => 'exists:attachments,id'
        ]);
        
        $results = [];
        $errors = [];
        
        foreach ($request->files as $fileId) {
            try {
                $attachment = Attachment::findOrFail($fileId);
                
                switch ($request->action) {
                    case 'delete':
                        $usage = $this->getFileUsage($attachment);
                        if ($usage['total_usage'] > 0) {
                            $errors[] = "Cannot delete {$attachment->original_name} - file is in use";
                        } else {
                            $this->mediaService->deleteFile($attachment);
                            $this->cacheService->clearAttachmentCaches($attachment->id);
                            $results[] = "Deleted {$attachment->original_name}";
                        }
                        break;
                        
                    case 'move':
                        $attachment->update(['folder' => $request->target_folder]);
                        $this->cacheService->clearAttachmentCaches($attachment->id);
                        $results[] = "Moved {$attachment->original_name}";
                        break;
                        
                    case 'update_alt_text':
                        $attachment->update(['alt_text' => $request->new_alt_text]);
                        $this->cacheService->clearAttachmentCaches($attachment->id);
                        $results[] = "Updated alt text for {$attachment->original_name}";
                        break;
                }
                
            } catch (\Exception $e) {
                $errors[] = "Error processing file ID {$fileId}: " . $e->getMessage();
            }
        }
        
        return response()->json([
            'success' => count($results) > 0,
            'results' => $results,
            'errors' => $errors,
            'message' => count($results) . ' files processed successfully'
        ]);
    }

    /**
     * Get folder contents
     */
    public function getFolderContents($folder = null)
    {
        $query = Attachment::where('is_active', true);
        
        if ($folder && $folder !== 'all') {
            $query->where('folder', $folder);
        }
        
        $files = $query->orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'files' => $files->map(function($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->original_name,
                    'url' => $file->url,
                    'thumbnail' => $file->thumbnail_url,
                    'size' => $file->file_size,
                    'type' => $file->file_type,
                    'alt_text' => $file->alt_text,
                    'created_at' => $file->created_at->format('M j, Y')
                ];
            })
        ]);
    }

    /**
     * Create new folder
     */
    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\-_\s]+$/',
            'parent' => 'nullable|string'
        ]);
        
        $folderName = trim($request->name);
        $parentFolder = $request->parent ?: 'uploads';
        $fullPath = $parentFolder . '/' . $folderName;
        
        try {
            // Create the directory
            Storage::disk('public')->makeDirectory($fullPath);
            
            return response()->json([
                'success' => true,
                'message' => 'Folder created successfully',
                'folder' => $fullPath
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create folder: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get media library statistics
     */
    public function getStats()
    {
        $stats = $this->mediaService->getStats();
        
        // Add more detailed stats
        $stats['by_type'] = [
            'images' => Attachment::where('mime_type', 'like', 'image/%')->count(),
            'documents' => Attachment::whereIn('mime_type', [
                'application/pdf', 'application/msword', 
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ])->count(),
            'videos' => Attachment::where('mime_type', 'like', 'video/%')->count(),
            'audio' => Attachment::where('mime_type', 'like', 'audio/%')->count(),
            'other' => Attachment::where('mime_type', 'not like', 'image/%')
                                 ->where('mime_type', 'not like', 'video/%')
                                 ->where('mime_type', 'not like', 'audio/%')
                                 ->whereNotIn('mime_type', [
                                     'application/pdf', 'application/msword',
                                     'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                                 ])->count()
        ];
        
        $stats['recent_activity'] = Attachment::with('uploader')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json($stats);
    }

    /**
     * Helper method to get file usage
     */
    private function getFileUsage($attachment)
    {
        return [
            'pages' => $attachment->pages()->select('id', 'name', 'slug')->get(),
            'sections' => $attachment->sections()->select('id', 'name', 'alias')->get(),
            'total_usage' => $attachment->usage_count ?: 0,
            'last_used_at' => $attachment->last_used_at
        ];
    }
}
