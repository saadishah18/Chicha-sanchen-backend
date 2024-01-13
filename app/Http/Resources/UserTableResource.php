<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $actions = view('admin.pages.users.actions',['user' => $this])->render();
        return [
            'id' => $this->id,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'email' => $this->email,
            'dob' => Carbon::parse($this->dob)->toDateString(),
            'formatted_dob' => Carbon::parse($this->dob)->toFormattedDateString(),
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            "actions" => $actions
        ];
    }
}
