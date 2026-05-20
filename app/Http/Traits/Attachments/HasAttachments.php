<?php

namespace App\Http\Traits\Attachments;


use App\Models\Attachment;

trait HasAttachments
{
    use HandlesAttachments;

    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachable', 'attachables');
    }
}