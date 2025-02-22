<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhoneRequest;
use App\Services\SendOtp;
use App\Traits\ImagesOperations;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    use ImagesOperations;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
            'phone_code' => 'required',
            'phone_number' => 'required',
            'step' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $checkPhoneNumber = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->first();
        if (!empty($checkPhoneNumber)) {
            return $this->sendError('Validation Error.', "This phone number is already exists.");
        }

        if ($request->step == 1) {
            $otp = random_int(100000, 999999);
            $success['otp'] = $otp;
            return $this->sendResponse($success, 'OTP send successfully.');
        }

        $user = User::create([
            "name" => $request->name,
            "date_of_birth" => $request->date_of_birth,
            "phone_code" => $request->phone_code,
            "phone_number" => $request->phone_number,
            "country_code" => $request->country_code,
            "password" => bcrypt($request->password),
            "device_type" => $request->device_type,
            "device_token" => $request->device_token,
        ]);
        $user['token'] = $user->createToken('SANAACADEMY')->accessToken;

        return $this->sendResponse($user, 'User register successfully.');
    }

    public function resend_code(Request $request)
    {
        $request->validate([
            'phone_code' => 'required',
            'phone_number' => 'required',
        ]);

        $ip = $request->ip();
        try {
            $this->send_code($request->phone_code, $request->phone_number, $ip);
            return response()->json([
                'message' => 'Code sent successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Determine if a phone number is Iraqi.
     *
     * Adjust this method based on your criteria. This example assumes that
     * Iraqi numbers start with +964 or 00964.
     */
    private function isIraqiPhone(string $phone): bool
    {
        return (bool)preg_match('/^(?:\+964|00964)/', $phone);
    }

    /**
     * @throws \Exception
     */
    public function send_code(User $user, $phone_code, $phone_number, $ip): bool
    {

        $phone = $phone_code . $phone_number;

        // Determine if the phone number is Iraqi
        $isIraqi = $this->isIraqiPhone($phone);

        // Check the time of the last request for this phone
        $lastRequest = PhoneRequest::where('phone_code', $phone_code)
            ->where('phone_number', $phone_number)
            ->latest('created_at')
            ->first();

        if ($lastRequest && now()->diffInSeconds($lastRequest->created_at) < 30) {
            throw new \Exception('Please wait at least 30 seconds before requesting again.', 429);
        }

        if ($isIraqi) {
            // Count requests in the last hour for Iraqi numbers.
            $requestsCount = PhoneRequest::where('phone_code', $phone_code)
                ->where('phone_number', $phone_number)
                ->where('created_at', '>=', now()->subHour())
                ->count();

            if ($requestsCount >= 5) {
                throw new \Exception('Sorry your limit is reached please contact us or wait 1 hour to request OTP again', 429);
            }
        } else {
            // For non-Iraqi numbers, count all requests ever logged.
            $requestsCount = PhoneRequest::where('phone_code', $phone_code)
                ->where('phone_number', $phone_number)
                ->count();

            if ($requestsCount >= 5) {
                throw new \Exception('This phone number is blocked due to exceeding the allowed number of requests.', 403);
            }
        }

        // Log the new request
        PhoneRequest::create([
            'phone_code' => $phone_code,
            'phone_number' => $phone_number,
            'ip' => $ip,
        ]);

        new SendOtp($user);

        return true;
    }

    public function phone_exists(Request $request)
    {
        $request->validate([
            'phone_code' => 'required',
            'phone_number' => 'required',
        ]);

        $checkPhoneNumber = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->first();
        if (empty($checkPhoneNumber)) {
            return $this->sendResponse([
                'redirect_to' => 'register-first-step'
            ], 'This phone number is not exists', 404);
        }
        return $this->sendResponse([
            'redirect_to' => $checkPhoneNumber->password ? 'login' : 'register-second-step'
        ], 'This phone number is exists.', 200);
    }

    public function register_first_step(Request $request)
    {
        $request->validate([
            'phone_code' => 'required',
            'phone_number' => 'required',
        ]);

        $user = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->first();
        if (empty($user)) {
            //sent otp to whatsapp
            $user = User::create([
                "phone_code" => $request->phone_code,
                "phone_number" => $request->phone_number,
            ]);

            try {
                $this->send_code($user, $request->phone_code, $request->phone_number, $request->ip());
                return $this->sendResponse([], 'Enter the OTP code you received on whatsapp');
            } catch (\Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], $e->getCode());
            }
        }
        return $this->sendResponse([], 'Your phone number is already exists', 422);
    }

    public function register_second_step(Request $request)
    {
        $request->validate([
//            'otp' => 'required',
            'phone_code' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        $user = User::where("phone_code", $request->phone_code)
            ->where("phone_number", $request->phone_number)
//            ->where("otp", $request->otp)
            ->first();

        if (empty($user)) {
            return $this->sendResponse([], 'This phone number is not exists', 404);
        }

        if ($user->otp!=null) {
            return $this->sendResponse([], 'Please verify your phone number first', 404);
        }

//        if ($user->otp != $request->otp) {
//            return $this->sendResponse([], 'OTP is incorrect', 404);
//        }


        $user->password = Hash::make($request->password);
        $user->otp = null;
        $user->save();

        $user['token'] = $user->createToken('SANAACADEMY')->accessToken;

        $user['IsProfileSetupComplete'] = $this->isUserProfileSetupCompleted($user);
        $user['ProfileSetupPercentage'] = $this->getUserProfileCompletionPercentage($user);


        return $this->sendResponse($user, 'User login successfully.', 200);

    }


    public function verify_otp(Request $request)
    {

        $request->validate([
            'otp' => 'required',
            'phone_code' => 'required',
            'phone_number' => 'required',

        ]);

        $user = User::where("phone_code", $request->phone_code)
            ->where("phone_number", $request->phone_number)
            ->first();

        if (empty($user)) {
            return $this->sendResponse([], 'This phone number is not exists', 404);
        }

        if ($user->otp != $request->otp) {
            return $this->sendResponse([], 'OTP is incorrect', 422);
        }

        $user->otp = null;
        $user->save();

        return $this->sendResponse([], 'OTP is correct', 200);
    }

    //if user already exists
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_code' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $user = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->first();
        if (empty($user)) {
            return $this->sendError('Validation Error.', "This phone number is not exists.", 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return $this->sendError('Validation Error.', "Password is incorrect.", 404);
        }

        $user->device_type = $request->device_type;
        $user->device_token = $request->device_token;
        $user->save();

        $user['token'] = $user->createToken('SANAACADEMY')->accessToken;


        $user['IsProfileSetupComplete'] = $this->isUserProfileSetupCompleted($user);
        $user['ProfileSetupPercentage'] = $this->getUserProfileCompletionPercentage($user);

        return $this->sendResponse($user, 'User login successfully.', 200);
    }

    public function get_profile()
    {
        $user = User::where("id", auth()->user()->id)
            ->select("id", "name", "name_ku", "gender", "date_of_birth", "phone_code", "phone_number", "image", "created_at", "updated_at")
            ->with(["city", "province"])
            ->first();

        $user->created_at = $user->created_at->format('Y-m-d H:i:s');
        $user->updated_at = $user->updated_at->format('Y-m-d H:i:s');
        $user['IsProfileSetupComplete'] = $this->isUserProfileSetupCompleted($user);
        $user['ProfileSetupPercentage'] = $this->getUserProfileCompletionPercentage($user);
        return $this->sendResponse($user, 'User profile get successfully.');
    }

    public function update_profile(Request $request)
    {

        $request->validate([
            'image' => 'nullable|image',
            'name' => 'required|string|max:50',
            'name_ku' => 'required|string|max:50',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date|date_format:Y-m-d',
            'phone_code' => 'required',
            'phone_number' => 'required',
            'city_id' => 'nullable|exists:cities,id',
            'province_id' => 'nullable|exists:provinces,id',
        ]);


        $checkPhoneNumber = User::where("phone_code", $request->phone_code)
            ->where("phone_number", $request->phone_number)
            ->where("id", "!=", auth()->user()->id)
            ->first();
        if (!empty($checkPhoneNumber)) {
            return $this->sendError('Validation Error.', "This phone number is already exists.");
        }
        $user = User::where("id", auth()->user()->id)
            ->select("id", "name", "name_ku", "gender", "date_of_birth", "phone_code", "phone_number", "image", "created_at", "updated_at")
            ->first();

        $userArr = [
            "name" => $request->name ?? $user->name,
            "name_ku" => $request->name_ku ?? $user->name,
            "gender" => $request->gender ?? $user->gender,
            "date_of_birth" => $request->date_of_birth ?? $user->date_of_birth,
            "phone_code" => $request->phone_code ?? $user->phone_code,
            "phone_number" => $request->phone_number ?? $user->phone_number,
            "city_id" => $request->city_id ?? $user->city_id,
            "province_id" => $request->province_id ?? $user->province_id,
        ];

        if ($request->hasFile('image')) {
            $userArr['image'] = $this->storeFile($request->image, 'users/images');
        }

        $user->update($userArr);


        return $this->sendResponse($user, 'User profile updated successfully.');
    }


    function getUserProfileCompletionPercentage($user): float
    {

        $profileSetupPercentage = 0;
        if ($user->image) {
            $profileSetupPercentage += 25;
        }

        if ($user->name) {
            $profileSetupPercentage += 10;
        }
        if ($user->name_ku) {
            $profileSetupPercentage += 10;
        }

        if ($user->gender) {
            $profileSetupPercentage += 5;
        }
        if ($user->date_of_birth) {
            $profileSetupPercentage += 5;
        }
        if ($user->phone_code && $user->phone_number) {
            $profileSetupPercentage += 20;
        }
        if ($user->city_id && $user->province_id) {
            $profileSetupPercentage += 25;
        }


        return $profileSetupPercentage;
    }

    private function isUserProfileSetupCompleted($user): bool
    {
        $isProfileSetupComplete = false;
        if ($user->image &&
            $user->name &&
            $user->name_ku &&
            $user->gender &&
            $user->date_of_birth &&
            $user->phone_code &&
            $user->phone_number &&
            $user->city_id &&
            $user->province_id) {
            $isProfileSetupComplete = true;
        }
        return $isProfileSetupComplete;
    }

    public function delete_user()
    {
        User::where("id", auth()->user()->id)->delete();
        return $this->sendResponse([], 'User deleted successfully.');
    }

    public function logout()
    {
        auth()->user()->token()->revoke();
        return $this->sendResponse([], 'User logged out successfully.');
    }
}
