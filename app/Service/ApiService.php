<?php namespace App\Service;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ApiService
{
    private $validator;

    private function make_validator($rules, $messages = []): void
    {
        $this->validator = Validator::make(request()->all(), $rules, $messages);
    }

    public function response($data = null, $message = null, $status = 200): \Illuminate\Http\JsonResponse
    {
        $message = $message ?? trans('response.success');
        return Response::json([
            'data' => $data,
            'status' => $status,
            'message' => $message,
//            'payload' => request()->all(),
        ], $status);
    }

    public function not_found($message = null): \Illuminate\Http\JsonResponse
    {
        $message = $message ?? trans('response.not_fount');
        return $this->response(null, $message, 404);
    }

    public function validate($rules, $messages = []): bool
    {
        $this->make_validator($rules, $messages);
        return !$this->validator->fails();
    }

    public function validation_errors(): \Illuminate\Http\JsonResponse
    {
        $errors = $this->validator->errors()->toArray();
        $errors = array_values($errors);
        $errors = call_user_func_array('array_merge', $errors);

        return $this->response($errors, $this->validator->errors()->first(), 422);
    }

    public function error($message = '', $status = 422): \Illuminate\Http\JsonResponse
    {
        return $this->response(null, $message, $status);
    }

    public function server_error($throwable): \Illuminate\Http\JsonResponse
    {
        $code = $throwable->getCode() ?? 500;
        // Check if the code is numeric and greater than 0
        if (is_numeric($code) && $code > 0) {
            $statusCode = $code;
        } else {
            // If the code is not numeric or less than or equal to 0, set a default
            $statusCode = 500;
        }
        // If you want to include the original error code when it's not numeric
        if (!is_numeric($code)) {
            $response['original_code'] = $code;
        }
        return $this->response(config('app.debug') ? $throwable->getTrace() : null, config('app.debug') ? $throwable->getMessage() : trans('response.server_error'), $statusCode);
    }

    public function forbidden(): \Illuminate\Http\JsonResponse
    {
        return $this->response(null, trans('response.forbidden'), 403);
    }

    public function unauthenticated(): \Illuminate\Http\JsonResponse
    {
        return $this->response(null, trans('response.unauthenticated'), 401);
    }

}
