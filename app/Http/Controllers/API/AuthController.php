<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends BaseController
{
    /**
     * Auth api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 200);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $email = $request->email;

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //user sent their email
            Auth::attempt(['email' => $email, 'password' => $request->password]);
        }

        //was any of those correct ?
        if (Auth::check()) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'], 200);
        }
    }

    /**
     * Forgot Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|exists:users,email,phone,' . $request->phone . ',secret,' . $request->secret,
            'email' => 'required|email|exists:users',
            'phone' => 'required|regex:/(0)[0-9]{10,13}/|exists:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'secret' => 'required|exists:users',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 200);
        }

        $user = User::where('email', $request->email)->where('phone', $request->phone)->where('secret', $request->secret);

        if (!$user->exists()) {
            return $this->sendError('We cant verify you with those details', 200);
        } else {
            // User found
            $user->update(['password' => bcrypt($request->password)]);

            return $this->sendResponse(NULL, 'Congrats, Now you can login with your new password');
        }
    }

    /**
     * Current User api
     *
     * @return \Illuminate\Http\Response
     */
    public function currentUser()
    {
        return $this->sendResponse(Auth::user(), 'Current User');
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user = Auth::user()->currentAccessToken()->delete();

        return $this->sendResponse($user, 'Logout successfully.');
    }

    /**
     * Change Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|current_password:sanctum',
            'new_password' => 'required',
            'new_confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 200);
        }

        User::find(Auth::user()->id)->update(['password' => bcrypt($request->new_password)]);

        return $this->sendResponse(Auth::user(), 'Password change successfully.');
    }

    /**
     * Update Profile api
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|regex:/(0)[0-9]{10,13}/|unique:users,phone,' . Auth::user()->id,
            'gender' => 'required',
            'birth_date' => 'required',
            'biography' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 200);
        }

        User::find(Auth::user()->id)->update([
            'name' => $request->name, 'email' => $request->email, 'phone' => $request->phone,
            'gender' => $request->gender, 'birth_date' => $request->birth_date,
            'biography' => $request->biography, 'job_role' => $request->job_role,
        ]);

        return $this->sendResponse(Auth::user(), 'Update Profile successfully.');
    }
}
