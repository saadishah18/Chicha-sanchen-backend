<?php


namespace App\Developer\Traits;


use App\Developer\Services\UploadsService;

trait HasProfilePictureUpload
{
    public function uploadImage($request,$fileNameColumn,$uploadsPath = 'avatars',$deleteOldFile = false)
    {
        if ($request->hasFile($fileNameColumn)) {
            $primaryKey = $this->getKeyName();

            $filename = ($this->{$primaryKey}) . '_profile_pic'  .'.'. $request->file($fileNameColumn)->getClientOriginalExtension();

            if ($deleteOldFile){
                $this->deleteOld($this->getProfilePictureUrl());
            }
            $fileFullPathWithName = UploadsService::uploadAccordingToStorageDisk($request->{$fileNameColumn},$uploadsPath,$filename,true,true);

            if(!empty($fileFullPathWithName)){
                $this->profile_pic = $fileFullPathWithName['name'];
                $this->save();
            }

        }
    }

    public function deleteOld($filepath)
    {
        if(!is_null($filepath)){
            UploadsService::delete($filepath);
        }
    }
}
