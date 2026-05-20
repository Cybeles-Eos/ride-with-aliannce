<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileUploadService
{
    public function upload($file, $folder = 'uploads', $disk = 'public', $altText = null, $title = null)
    {
        $path = $file->store($folder, $disk);
        
        return Attachment::create([
            'name' => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)),
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'path' => $path,
            'url' => Storage::disk($disk)->url($path),
            'folder' => $folder,
            'disk' => $disk,
            'alt_text' => $altText ?: $this->generateAltText($file),
            'title' => $title ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'metadata' => $this->extractMetadata($file),
            'uploaded_by' => auth()->id(),
            'is_active' => true,
            // Legacy fields for backward compatibility
            'alias' => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension(),
            'mime' => $file->getMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'identifier' => 'default'
        ]);
    }
    
    public function uploadMultiple($files, $folder = 'uploads', $disk = 'public')
    {
        $attachments = [];
        
        foreach ($files as $file) {
            $attachments[] = $this->upload($file, $folder, $disk);
        }
        
        return $attachments;
    }
    
    public function uploadWithOptions($file, $options = [])
    {
        $folder = $options['folder'] ?? 'uploads/' . date('Y/m');
        $disk = $options['disk'] ?? 'public';
        $altText = $options['alt_text'] ?? null;
        $title = $options['title'] ?? null;
        
        return $this->upload($file, $folder, $disk, $altText, $title);
    }
    
    public function delete($attachment)
    {
        // Delete physical file
        if (Storage::disk($attachment->disk)->exists($attachment->path)) {
            Storage::disk($attachment->disk)->delete($attachment->path);
        }
        
        // Delete thumbnail if exists
        $thumbnailPath = $this->getThumbnailPath($attachment->path);
        if (Storage::disk($attachment->disk)->exists($thumbnailPath)) {
            Storage::disk($attachment->disk)->delete($thumbnailPath);
        }
        
        // Delete attachment record
        $attachment->delete();
        
        return true;
    }
    
    private function generateAltText($file)
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return ucwords(str_replace(['-', '_'], ' ', $filename));
    }
    
    private function extractMetadata($file)
    {
        $metadata = [
            'uploaded_at' => now()->toISOString(),
            'original_size' => $file->getSize()
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
                // If image processing fails, just continue without metadata
            }
        }
        
        return $metadata;
    }
    
    private function getThumbnailPath($path)
    {
        $pathInfo = pathinfo($path);
        return $pathInfo['dirname'] . '/thumbnails/' . $pathInfo['filename'] . '_thumb.' . $pathInfo['extension'];
    }
    
    public function generateThumbnail($attachment, $width = 300, $height = 300)
    {
        if (!$attachment->is_image) {
            return false;
        }
        
        try {
            $fullPath = Storage::disk($attachment->disk)->path($attachment->path);
            $thumbnailPath = $this->getThumbnailPath($attachment->path);
            
            // Ensure thumbnails directory exists
            $thumbnailDir = dirname(Storage::disk($attachment->disk)->path($thumbnailPath));
            if (!file_exists($thumbnailDir)) {
                mkdir($thumbnailDir, 0755, true);
            }
            
            $image = Image::make($fullPath);
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            Storage::disk($attachment->disk)->put($thumbnailPath, $image->encode());
            
            return Storage::disk($attachment->disk)->url($thumbnailPath);
        } catch (\Exception $e) {
            \Log::error('Thumbnail generation failed: ' . $e->getMessage());
            return false;
        }
    }
}
