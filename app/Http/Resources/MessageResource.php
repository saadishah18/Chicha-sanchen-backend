<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{

    public function toArray($request)
    {
        $files = $this->files ? json_decode($this->files) : [];
        foreach ($files as &$file) {
            $file->path = public_path('/files/messages/' . $file->path);
        }
        return [
            'id' => $this->id,
            'receiver_id' => $this->receiver_id,
            'sender_id' => $this->sender_id,
            'message' => $this->message,
            'files' => $files,
            'created_at' => $this->created_at,
        ];
    }
}
