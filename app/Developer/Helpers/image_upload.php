<?php

if (!function_exists('handleAttachmentFromFileManagerHtml')) {
    function handleAttachmentFromFileManagerHtml($attachment,&$data)
    {
        preg_match_all('/<img\s+.*?src=[\"\']?([^\"\' >]*)[\"\']?[^>]*>/i', $attachment, $matches);

        if (isset($matches[1])){
            foreach ($matches[1] as $match){
                $domainLessImageUrls = removeAnyDomainFromUrl($match);
                $pathInfo = pathinfo($match);

                $data['attachment'] = $pathInfo['basename'];
                $data['attachment_type'] = $pathInfo['extension'];
                $data['attachment_path'] = $domainLessImageUrls;
                break; //just take 1st image and ignore others.
            }
        }
        dd($data);
    }
}
if (!function_exists('checkIfDirectoryIsAvailable')) {
    function checkIfDirectoryIsAvailable($directory)
    {
        if (!\Illuminate\Support\Facades\File::exists(public_path($directory))) {
            \Illuminate\Support\Facades\File::makeDirectory(public_path($directory), 0777, true);
        }
    }
}
if (!function_exists('checkIfDirectoryIsAvailableThenDeleteIt')) {
    function checkIfDirectoryIsAvailableThenDeleteIt($directory)
    {
        \Illuminate\Support\Facades\File::deleteDirectory(public_path($directory));
    }
}

if (!function_exists('checkIfFileIsUploadedThenDelete')) {

    function checkIfFileIsUploadedThenDelete($imagePath)
    {
        if(!is_null($imagePath) && \Illuminate\Support\Facades\File::exists(public_path($imagePath))){
            \Illuminate\Support\Facades\File::delete(public_path($imagePath));
            return true;
        }
        return false;
    }
}

if (!function_exists('checkIfFileExists')) {

    function checkIfFileExists($imagePath)
    {
        if(!is_null($imagePath)){
            \Illuminate\Support\Facades\File::exists(public_path($imagePath));
            return true;
        }
        return false;
    }
}

if (!function_exists('checkIfUploadedFileHasSameName')) {

    function checkIfUploadedFileHasSameName($imagePath)
    {
        if(!is_null($imagePath)){
            return file_exists(public_path($imagePath));
        }
        return false;
    }
}
