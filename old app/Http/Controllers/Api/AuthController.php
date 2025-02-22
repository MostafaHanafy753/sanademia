<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'date_of_birth' => 'required',
            'phone_code' => 'required',
            'phone_number' => 'required',
            'step' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $checkPhoneNumber = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->first();
        if(!empty($checkPhoneNumber)){
            return $this->sendError('Validation Error.', "This phone number is already exists.");
        }

        if($request->step == 1){
            $otp = random_int(100000, 999999);
            $success['otp'] =  $otp;
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
        $user['token'] =  $user->createToken('SANAACADEMY')->accessToken;

        return $this->sendResponse($user, 'User register successfully.');
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone_code' => 'required',
            'phone_number' => 'required',
            'step' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors()->first());
        }

        $checkPhoneNumber = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->first();
        if(empty($checkPhoneNumber)){
            return $this->sendError('Validation Error.', "This phone number is not exists.");
        }

        if($request->step == 1){
            $otp = random_int(100000, 999999);
            $success['otp'] =  $otp;
            return $this->sendResponse($success, 'OTP send successfully.');
        }

        $user = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->first();
        $user->device_type = $request->device_type;
        $user->device_token = $request->device_token;
        $user->save();

        $user['token'] =  $user->createToken('SANAACADEMY')->accessToken;
        return $this->sendResponse($user, 'User login successfully.');
    }

    public function get_profile()
    {
        $user = User::where("id", auth()->user()->id)->first();

        return $this->sendResponse($user, 'User profile get successfully.');
    }

    public function update_profile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'name' => 'required',
            'date_of_birth' => 'required',
            'phone_code' => 'required',
            'phone_number' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());
        }

        $checkPhoneNumber = User::where("phone_code", $request->phone_code)->where("phone_number", $request->phone_number)->where("id", "!=", auth()->user()->id)->first();
        if(!empty($checkPhoneNumber)){
            return $this->sendError('Validation Error.', "This phone number is already exists.");
        }

        $userArr = [
            "name" => $request->name,
            "date_of_birth" => $request->date_of_birth,
            "phone_code" => $request->phone_code,
            "phone_number" => $request->phone_number,
            "country_code" => $request->country_code,
            "address" => $request->address,
        ];

        if($request->hasFile('image'))
        {
            $imageName = rand(1111,9999) . time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $userArr['image'] = $imageName;
        }

        User::where("id", auth()->user()->id)->update($userArr);
        $user = User::where("id", auth()->user()->id)->first();
        return $this->sendResponse($user, 'User profile updated successfully.');
    }

    public function delete_user(){
        User::where("id", auth()->user()->id)->delete();
        return $this->sendResponse([], 'User deleted successfully.');
    }
}
