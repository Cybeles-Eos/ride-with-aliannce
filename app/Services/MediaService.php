<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MediaService
{
    protected $disk;
    protected $fileUploadService;
    
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->disk = Storage::disk('public');
        $this->fileUploadService = $fileUploadService;
    }
    
    public function uploadFile($file, $options = [])
    {
        $folder = $options['folder'] ?? 'uploads/' . date('Y/m');
        $filename = $this->generateUniqueFilename($file, $folder);
        $path = $folder . '/' . $filename;
        
        // Store file
        $this->disk->putFileAs($folder, $file, $filename);
        
        // Generate thumbnail for images
        if (str_starts_with($file->getMimeType(), 'image/')) {
            $this->generateThumbnail($path);
        }
        
        // Create attachment record
        $attachment = Attachment::create([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
            'url' => $this->disk->url($path),
            'alt_text' => $options['alt_text'] ?? $this->generateAltText($file->getClientOriginalName()),
            'title' => $options['title'] ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'folder' => $folder,
            'disk' => 'public',
            'uploaded_by' => $options['uploaded_by'] ?? auth()->id(),
            'is_active' => true,
            'metadata' => $this->extractMetadata($file),
            // Legacy fields for backward compatibility
            'alias' => $filename,
            'mime' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'identifier' => 'default'
        ]);
        
        return $attachment;
    }
    
    public function deleteFile($attachment)
    {
        // Delete physical file
        if ($this->disk->exists($attachment->path)) {
            $this->disk->delete($attachment->path);
        }
        
        // Delete thumbnail
        $thumbnailPath = $this->getThumbnailPath($attachment->path);
        if ($this->disk->exists($thumbnailPath)) {
            $this->disk->delete($thumbnailPath);
        }
        
        // Delete attachment record
        $attachment->delete();
    }
    
    public function getFolders()
    {
        $directories = $this->disk->directories('uploads');
        $folders = ['all' => 'All Folders'];
        
        foreach ($directories as $dir) {
            $folderName = basename($dir);
            $folders[$dir] = $folderName;
        }
        
        return $folders;
    }
    
    public function getStats()
    {
        return [
            'total_files' => Attachment::count(),
            'total_size' => Attachment::sum('size'),
            'total_size_formatted' => $this->formatBytes(Attachment::sum('size')),
            'images' => Attachment::where('mime_type', 'like', 'image/%')->count(),
            'documents' => Attachment::whereIn('mime_type', [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ])->count(),
            'recent_uploads' => Attachment::where('created_at', '>=', now()->subDays(7))->count(),
            'unused_files' => Attachment::where('usage_count', 0)->count(),
            'active_files' => Attachment::where('is_active', true)->count()
        ];
    }
    
    public function searchFiles($query, $filters = [])
    {
        $search = Attachment::with('uploader');
        
        // Text search
        if ($query) {
            $search->where(function($q) use ($query) {
                $q->where('original_name', 'like', "%{$query}%")
                  ->orWhere('alt_text', 'like', "%{$query}%")
                  ->orWhere('title', 'like', "%{$query}%")
                  ->orWhere('caption', 'like', "%{$query}%");
            });
        }
        
        // Filter by type
        if (isset($filters['type']) && $filters['type'] !== 'all') {
            if ($filters['type'] === 'images') {
                $search->where('mime_type', 'like', 'image/%');
            } elseif ($filters['type'] === 'documents') {
                $search->whereIn('mime_type', [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ]);
            } elseif ($filters['type'] === 'videos') {
                $search->where('mime_type', 'like', 'video/%');
            }
        }
        
        // Filter by folder
        if (isset($filters['folder']) && $filters['folder'] !== 'all') {
            $search->where('folder', $filters['folder']);
        }
        
        // Filter by usage
        if (isset($filters['usage'])) {
            if ($filters['usage'] === 'used') {
                $search->where('usage_count', '>', 0);
            } elseif ($filters['usage'] === 'unused') {
                $search->where('usage_count', 0);
            }
        }
        
        // Filter by active status
        if (isset($filters['status'])) {
            $search->where('is_active', $filters['status'] === 'active');
        }
        
        return $search;
    }
    
    public function organizeFiles($attachmentIds, $folder)
    {
        $moved = 0;
        
        foreach ($attachmentIds as $id) {
            $attachment = Attachment::find($id);
            if ($attachment) {
                $oldPath = $attachment->path;
                $filename = basename($oldPath);
                $newPath = $folder . '/' . $filename;
                
                // Move physical file
                if ($this->disk->exists($oldPath)) {
                    $this->disk->move($oldPath, $newPath);
                    
                    // Update attachment record
                    $attachment->update([
                        'path' => $newPath,
                        'folder' => $folder,
                        'url' => $this->disk->url($newPath)
                    ]);
                    
                    $moved++;
                }
            }
        }
        
        return $moved;
    }
    
    public function bulkDelete($attachmentIds)
    {
        $deleted = 0;
        
        foreach ($attachmentIds as $id) {
            $attachment = Attachment::find($id);
            if ($attachment && $attachment->usage_count == 0) {
                $this->deleteFile($attachment);
                $deleted++;
            }
        }
        
        return $deleted;
    }
    
    public function getUsage($attachment)
    {
        $usage = [
            'pages' => $attachment->pages()->select('id', 'name', 'slug')->get(),
            'sections' => $attachment->sections()->select('id', 'name', 'alias')->get(),
            'total_usage' => $attachment->usage_count,
            'last_used' => $attachment->last_used_at
        ];
        
        return $usage;
    }
    
    private function generateUniqueFilename($file, $folder)
    {
        $extension = $file->getClientOriginalExtension();
        $basename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = Str::slug($basename) . '.' . $extension;
        
        $counter = 1;
        while ($this->disk->exists($folder . '/' . $filename)) {
            $filename = Str::slug($basename) . '-' . $counter . '.' . $extension;
            $counter++;
        }
        
        return $filename;
    }
    
    private function generateThumbnail($path)
    {
        try {
            $fullPath = $this->disk->path($path);
            $thumbnailPath = $this->getThumbnailPath($path);
            
            // Ensure thumbnails directory exists
            $thumbnailDir = dirname($this->disk->path($thumbnailPath));
            if (!file_exists($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }
            
            $image = Image::make($fullPath);
            $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $this->disk->put($thumbnailPath, $image->encode());
        } catch (\Exception $e) {
            \Log::error('Thumbnail generation failed: ' . $e->getMessage());
        }
    }
    
    private function getThumbnailPath($path)
    {
        $pathInfo = pathinfo($path);
        return $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
    }
    
    private function generateAltText($filename)
    {
        return Str::title(str_replace(['-', '_'], ' ', pathinfo($filename, PATHINFO_FILENAME)));
    }
    
    private function extractMetadata($file)
    {
        $metadata = [
            'uploaded_at' => now()->toISOString()
        ];
        
        if (str_starts_with($file->getMimeType(), 'image/')) {
            try {
                $image = Image::make($file);
                $metadata = array_merge($metadata, [
                    'width' => $image->width(),
                    'height' => $image->height(),
                    'aspect_ratio' => round($image->width() / $image->height(), 2)
                ]);
            } catch (\Exception $e) {
                // If image processing fails, continue without metadata
            }
        }
        
        return $metadata;
    }
    
    private function formatBytes($size, $precision = 2)
    {
        if (!$size) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }
}
