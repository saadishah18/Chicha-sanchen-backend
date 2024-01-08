<?php


namespace App\Developer\Traits;


use App\Service\UploadsService;

trait HasImageUpload
{
    public function uploadImage($request,$fileNameColumn,$uploadsPath,$deleteOldFile = false)
    {
        dd($request->hasFile($fileNameColumn));
        if ($request->hasFile($fileNameColumn)) {
            $primaryKey = $this->getKeyName();
            $fileNamePrefix = $fileNameColumn;

            $filename = $fileNamePrefix . ($primaryKey) . '_'  .'.'. $request->file($fileNameColumn)->getClientOriginalExtension();
            dd($filename);
            if ($deleteOldFile){
                $this->deleteOld($this->{$fileNameColumn});
            }
            $fileFullPathWithName = UploadsService::uploadAccordingToStorageDisk($request->{$fileNameColumn},$uploadsPath,$filename,true,true);

            if(!empty($fileFullPathWithName)){
                $this->image = $fileFullPathWithName['name'];
//                $this->attachment_type = $request->file($fileNameColumn)->getClientOriginalExtension();
//                $this->attachment_path = $fileFullPathWithName['url'];
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
