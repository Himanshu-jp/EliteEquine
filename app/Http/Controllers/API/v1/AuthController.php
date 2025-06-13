<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\v1\RegisterRequest;
use App\Http\Requests\API\v1\LoginRequest;
use App\Http\Requests\API\v1\UpdateProfileRequest;
use App\Http\Requests\API\v1\ChangePasswordRequest;
use App\Http\Requests\API\v1\UserSettingRequest;
use App\Http\Requests\API\v1\ForgetPasswordRequest;
use App\Http\Resources\API\v1\user\RegisterResource;
use App\Http\Resources\API\v1\user\ForgotPasswordResource;
use App\Services\Front\AuthService;
use App\Services\API\v1\UserService;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

// use Illuminate\Contracts\Encryption\DecryptException;

class AuthController extends BaseController
{
    protected AuthService $authService;
    protected UserService $userService;

    public function __construct(AuthService $authService, UserService $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * Register API
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['type'] = 'app';
            $user = $this->authService->register($data);

            // Check if registration failed
            if (!$user && !is_null($user)) {
                return $this->sendError('Registration failed.', 'Unable to create user.', 500);
            }

            // Optionally create token
            // $token = $user->createToken($data['device_name'])->plainTextToken;
            // $user->token = $token;
            
            $user = User::whereEmail($data['email'])->first();

            $response = new RegisterResource($user);

            return $this->sendResponse($response, 'User registered successfully.');

        } catch (\Exception $e) {
            // Log the error if needed: Log::error($e->getMessage());
            return $this->sendError('Registration error.', $e->getMessage(), 500);
        }
    }


    /**
     * Login API
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $credentials = $request->only('username', 'password');
        $deviceName = $request->device_name ?? 'web'; // default if missing

        $authResult = $this->userService->login($credentials, $deviceName);

        if (!$authResult['success']) {
            return $this->sendError('Unauthorized.', $authResult['message'], $authResult['code']);
        }

        return $this->sendResponse($authResult['data'], 'User logged in successfully.');
    }

    /**
     * User Profile API
     */
    public function userProfile(): JsonResponse
    {
        $authResult = $this->userService->profile();

        if (!$authResult['success']) {
            return $this->sendError('Unauthorized.', $authResult['message'], $authResult['code']);
        }

        return $this->sendResponse($authResult['data'], 'User profile fetched successfully.');
    }

    /**
     * Update Profile API
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userResult = $this->userService->updateProfile($data);

        if (!$userResult['success']) {
            return $this->sendError('Unauthorized.', $userResult['message'], $userResult['code']);
        }

        return $this->sendResponse($userResult['data'], 'Profile updated successfully.');
    }

    /**
     * user forget passord
     */
    public function forgotPassword(ForgetPasswordRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $result = $this->userService->forgotPassword($data);

            if (!$result['success']) {
                return $this->sendError('Failed', $result['message'], $result['code']);
            }

            $response = new ForgotPasswordResource($result['data']);
            return $this->sendResponse($response, 'Password reset link sent successfully.');

        } catch (\Exception $e) {
            // Optionally: Log::error($e);
            return $this->sendError('Password reset error.', $e->getMessage(), 500);
        }
    }

    /**
     * setting data
     */
    public function settingDetail(): JsonResponse
    {
        try {
            $result = $this->userService->settingDetail();

            if (!$result['success']) {
                return $this->sendError('Failed', $result['message'], $result['code']);
            }

            return $this->sendResponse($result['data'],'Settings fetched successfully.');

        } catch (\Exception $e) {
            // Optional: log error for debugging
            Log::error('Setting detail error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return $this->sendError(
                'Something went wrong.',
                $e->getMessage(),
                500
            );
        }
    }
    /**
     * setting update
     */
    public function settingUpdate(UserSettingRequest $request)
    {
        try {
            $data = $request->all();
            $result = $this->userService->settingUpdate($data);
            if (!$result['success']) {
                return $this->sendError('Failed', $result['message'], $result['code']);
            }

            return $this->sendResponse($result['data'],'Settings updated successfully.');

        } catch (\Exception $e) {
            // Optional: log error for debugging
            Log::error('Setting detail error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return $this->sendError(
                'Something went wrong.',
                $e->getMessage(),
                500
            );
        }
    }



    public function changePasswordUpdate(ChangePasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->userService->changePassword($data);

            if (!$result['success']) {
                return $this->sendError('Failed', $result['message'], $result['code']);
            }

            return $this->sendResponse($result['data'], 'Password changed successfully.');

        } catch (\Exception $e) {
            // Optionally: Log::error($e);
            return $this->sendError('Password reset error.', $e->getMessage(), 500);
        }
        
    }

    /**
     * Logout API
     */
    public function logout(): JsonResponse
    {
        $userResult = $this->userService->logout();

        if (!$userResult['success']) {
            return $this->sendError('Unauthorized.', $userResult['message'], $userResult['code']);
        }
        // Delete token
        // auth()->user()?->currentAccessToken()?->delete();

        return $this->sendResponse([], 'User logged out successfully.');
    }
}
