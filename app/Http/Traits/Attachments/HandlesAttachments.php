<?php

namespace App\Http\Traits\Attachments;


use App\Models\Attachment;
use Illuminate\Http\UploadedFile;

trait HandlesAttachments
{
    public function attach($files, $identifier = 'default')
    {
        if ($files instanceof UploadedFile)
            $this->handleUpload($files, $identifier);
        if (is_array($files) || $files instanceof \Traversable)
            foreach ($files as $file)
                $this->handleUpload($file, $identifier);
    }

    private function handleUpload(UploadedFile $file, $identifier)
    {
        $namespace = explode('\\', get_class($this));
        $class = end($namespace);
        $alias = str_random() . '.' . $file->getClientOriginalExtension();

        $attachment = new Attachment();
        $attachment->alias = $alias;
        $attachment->folder = $class;
        $attachment->mime = $file->getClientMimeType();
        $attachment->name = $file->getClientOriginalName();
        $attachment->extension = $file->getClientOriginalExtension();
        $attachment->identifier = $identifier;

        if ($identifier === 'default') {
            if (method_exists($this, 'attachment')) {
                $this->attachment()->count() > 0 && $this->attachment()->delete();

                $this->attachment()->save($attachment);
            } else if (method_exists($this, 'attachments')) {
                $this->attachments()->save($attachment);
            } else return null;
        } else {
            if (method_exists($this, $identifier)) {
                $this->$identifier()->count() > 0 && $identifier->$identifier()->delete();

                $this->$identifier()->save($attachment);
            }
        }

        $file->move(public_path('storage/' . $class), $attachment->alias);

        return $attachment;
    }
}