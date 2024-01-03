<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Mail\VerifyEmailApiNotification;
use App\Models\OTP;
use App\Models\SocialUser;
use App\Models\User;
use App\Notifications\OTPEmail;
use App\Service\Facades\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (!Api::validate(['email' => 'required|email', 'password' => 'required'])) {
                return Api::validation_errors();
            }

            $user = User::firstWhere('email', $request->email);
            if (!$user) {
                return Api::error(trans('auth.failed'));
            }
            if (!Hash::check($request->password, $user->password)) {
                return Api::error(trans('auth.password'));
            }

            return Api::response([
                'user' => new UserResource($user),
                'access_token' => $user->createToken('AccessToken')->plainTextToken
            ]);
        } catch (\Exception $exception) {
            dd($exception->getMessage()) ;
            return Api::server_error($exception);
        }

    }

    public function register(Request $request)
    {
        try {
            if (!Api::validate([
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
                'fname' => 'required',
                'lname' => 'required',
                ]
            )) {
                return Api::validation_errors();
            }
            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'dob' => $request->dob ?? Null,
                'fname' => $request->fname,
                'lname' => $request->lname,
            ]);
//                $url = URL::signedRoute('verify.email', ['user' => $user->id]);
//                $url = URL::temporarySignedRoute(
//                    'verify.email', now()->addMinutes(30), ['user' => $user->id]
//                );;
            $otp_code = generate_code(4);
            $check_otp = $this->checkOTPExits($otp_code, 'email',$request->email);
            $data = [
                'code' => $otp_code,
            ];
            Mail::to($request->email)->send(new VerifyEmailApiNotification($data));

            return Api::response([
                'user' => new UserResource($user),
                'access_token' => $user->createToken('AccessToken')->plainTextToken
            ],'User Created');
        } catch (\Exception $exception) {
//            dd($exception->getMessage()) ;
            return Api::server_error($exception);
        }
    }

    public function social(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Api::validate(['email' => 'required|email|unique:users', 'provider_id' => 'required', 'provider' => 'required|in:facebook,google,apple'])) {
                return Api::validation_errors();
            }

            $social_user = SocialUser::firstWhere($request->only(['provider', 'provider_id']));
            if (!$social_user) {
                $email = $request->has('email') ? $request->email : $request->provider_id . '@' . strtolower($request->provider) . '.com';
                $user = User::create([
                    'email' => $email,
                ]);
                SocialUser::create([
                    'user_id' => $user->id,
                    'provider_id' => $request->provider_id,
                    'provider' => $request->provider,
                ]);
                return Api::response([
                    'user' => new UserResource($user),
                    'access_token' => $user->createToken('AccessToken')->plainTextToken
                ]);
            } else {
                return Api::response([
                    'user' => new UserResource($social_user->user),
                    'access_token' => $social_user->user->createToken('AccessToken')->plainTextToken
                ]);
            }
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function sendForgotPasswordOTP(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Api::validate(['email' => 'required'])) {
                return Api::validation_errors();
            }
            $user = User::firstWhere($request->only('email'));
            if (!$user) {
                return Api::error(trans('auth.failed'));
            }

            $code_number = generate_code(4);

            OTP::create([
                'slug' => 'email',
                'value' => $request->email,
                'otp' => $code_number
            ]);

            $user->notify(new OTPEmail($code_number,'Forgot Password Email OTP'));
            return Api::response(data: ['opt_code' => $code_number], message: trans('auth.otp_sent', ['digit' => 6, 'medium' => 'email']));
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function forgotPasswordVerifyOTP(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Api::validate(['email' => 'required', 'otp' => 'required', 'password' => 'required|confirmed'])) {
                return Api::validation_errors();
            }

            $user = User::firstWhere($request->only('email'));
            if (!$user) {
                return Api::error(trans('User not found'));
            }

            if (!OTP::where(['slug' => 'email', 'value' => $user->email, 'otp' => $request->otp])) {
                return Api::error(trans('OTP did not matched'));
            }

            $user->update(['password' => bcrypt($request->password)]);

            return Api::response(message: trans('Password updated successfully'));
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function resendOTP(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Api::validate(['email' => 'required'])) {
                return Api::validation_errors();
            }

            $user = User::firstWhere($request->only('email'));
            if (!$user) {
                return Api::not_found();
            }
            $code_number = generate_code(4);

            OTP::create([
                'slug' => 'phone',
                'value' => $request->email,
                'otp' => $code_number
            ]);

            $user->notify(new OTPEmail($code_number,'OTP Verification'));
            return Api::response(message: trans('OTP send successully'));
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function updateDeviceToken(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if (!Api::validate(['token' => 'required'])) {
                return Api::validation_errors();
            }
            auth()->user()->update([
                'device_token' => $request->token
            ]);
            return Api::response(message: trans('auth.token_update'));
        } catch (\Exception $exception) {
            return Api::server_error($exception);
        }
    }

    public function verifyEmailOLD(Request $request)
    {
        $user = User::where('id', $request->user)->first();
        if (!$user || ! $request->hasValidSignature()) {
            return Api::error( 'Invalid verification link.', 422);
        }

        $user->markEmailAsVerified();

        return response()->json([
            'message' => 'Your email has been verified.',
            'user' => $user,
        ]);
    }

    public function verifyEmail(Request $request)
    {
        try {
            if (!Api::validate(['email' => 'required', 'otp' => 'required'])) {
                return Api::validation_errors();
            }

            $user = User::firstWhere($request->only('email'));
            if (!$user) {
                return Api::error(trans('User not found'));
            }

            if (!OTP::where(['slug' => 'email', 'value' => $user->email, 'otp' => $request->otp])->count()) {
                return Api::error(trans('OTP Expired! Resend again'));
            }

            if($user->email_verified_at == null){
                $user->update(['email_verified_at' => now()->toDateTimeString()]);
                OTP::where('value',$user->email)->delete();
            }
            return Api::response(new UserResource($user),message: 'Email verified successfully');
        } catch (\Exception $exception) {
//            dd($exception->getMessage());
            return Api::server_error($exception);
        }
    }

    public function checkOTPExits($code, $type, $value){
        $check_user_otp = OTP::where('slug',$type)->where('value',$value)->first();
        if($check_user_otp){
            $check_user_otp->otp = $code;
            $check_user_otp->update();
        }else{
            $check_user_otp = OTP::create([
                'slug' => $type,
                'value' => $value,
                'otp' => $code
            ]);
        }
        return $check_user_otp;
    }
}
