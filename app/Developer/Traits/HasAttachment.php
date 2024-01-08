<?php


namespace App\Developer\Traits;


trait HasAttachment
{
    public function attachmentUrl($path)
    {
        $attachmentPath = $path;
        if ($attachmentPath){
            $attachmentPath = removeAnyDomainFromUrl($path);
        }
        return $attachmentPath;
    }
}
