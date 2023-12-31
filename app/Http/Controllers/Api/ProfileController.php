<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Service\Facades\Api;

class ProfileController extends Controller
{
    public function get_info(UserRepository $user_repository, $user_id): \Illuminate\Http\JsonResponse
    {
        try {
            return $user_repository->get_one($user_id);
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function update(UserRepository $user_repository): \Illuminate\Http\JsonResponse
    {
        try {
            return $user_repository->update(auth()->user());
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

}
