<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Front\LoginRequest;
use App\Http\Requests\Front\RegisterRequest;
use App\Http\Requests\Front\ForgotPasswordRequest;
use App\Http\Requests\Front\ResetPasswordRequest;
use App\Http\Requests\Front\UserProfileUpdateRequest;
use App\Http\Requests\Front\UserDetailsUpdateRequest;
use App\Http\Requests\Front\ChangePasswordRequest;
use App\Models\Product;
use App\Models\UserDetailAlert;
use App\Models\UserDetails;
use App\Models\Favorite;
use App\Services\Front\AuthService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function dashboard()
    {
        $user = auth::user();
        $products = Product::with(['productDetail', 'image', 'disciplines', 'height', 'sex','category'])
            ->where(
                ['deleted_at' => null,'user_id' => $user->id]
            )
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();
        $favorites = Favorite::where('user_id', auth()->id())->count();
        return view('frontauth/dashboard', compact(['products', 'favorites']));
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('front/login');
        }
    }


    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 2; // Optional but helpful

        if (Auth::guard('web')->attempt($credentials)) {

            if (Auth::user()->email_verified_at === null) {
                Auth::logout();
                return redirect()->back()->with('error', 'Please verify your email before logging in.')->withInput();
            }
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->with('error', 'You have entered invalid credentials.')->withInput();
    }


    public function register()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('front/register');
        }
    }

    public function postRegister(RegisterRequest $request)
    {
        $result = $this->authService->register($request->all());
        return redirect()->route('login')->with('success', 'An email has been sent to your email address for verification.!');
    }

    public function verifyNewAccount($token, $type = null)
    {
        $type = $type ?? null;
        $result = $this->authService->verifyNewAccountService($token);
        if ($result) {
            if (!empty($type) && decrypt($type) == 'app') {
                return response()->json([
                    'success' => true,
                    'message' => 'Your account is verified now you can login into the panel!',
                    'data' => [],
                ], 200);
            }
            return redirect()->route('login')->with('success', 'Your account is verified now you can login into the panel!');
        } else {
            return redirect()->route('login')->with('error', 'Your account is not verified.');
        }
    }


    public function showForgetPasswordForm()
    {
        return view('front/forgotPassword');
    }

    public function submitForgetPasswordForm(ForgotPasswordRequest $request)
    {
        $result = $this->authService->forgotPassword($request->all());
        return redirect()->route('login')->with('success', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token, $type = null)
    {
        $type = $type ?? null;
        $result = $this->authService->resetPasswordCheckToken($token);
        if ($result) {
            return view('front/resetPassword', ['token' => $token, 'email' => $result->email, 'type' => $type]);
        } else {
            return redirect()->route('login')->with('error', 'This token is expired please generate new one!');
        }
    }

    public function submitResetPasswordForm(ResetPasswordRequest $request)
    {
        $result = $this->authService->resetPassword($request->all());
        if (!empty($request->type) && decrypt($request->type) == 'app') {
            return response()->json([
                'success' => true,
                'message' => 'Your password has been changed!',
                'data' => [],
            ], 200);
        }
        return redirect()->route('login')->with('success', 'Your password has been changed!');
    }

    public function profile()
    {
        $user = auth::user();
        return view('frontauth/profile', compact('user'));
    }

    public function profileEdit()
    {
        $user = auth::user();
        return view('frontauth/profileEdit', compact('user'));
    }

    public function profileUpdate(UserProfileUpdateRequest $request)
    {
        $user = auth::user();
        $result = $this->authService->profileUpdate($request->all(), $user);
        return redirect()->route('profile')->with('success', 'Profile details Updated Successfully');
    }

    public function changePassword()
    {
        return view('frontauth/changePassword');
    }

    public function changePasswordUpdate(ChangePasswordRequest $request)
    {
        $user = auth::user();
        $result = $this->authService->changePassword($request->all(), $user);
        if (!$result) {
            return redirect()->back()->with('error', 'The current password is incorrect.')->withInput();
        } else {
            return redirect()->back()->with('success', 'Your password has been changed!');
        }
    }


    public function settings()
    {
        $user = auth::user();
        $userDetails = UserDetails::where('user_id', $user->id)->first();
        $alertDetails = [];
        if ($userDetails) {
            $userDetailAlert = UserDetailAlert::where(['user_id' => $user->id, 'user_detail_id' => $userDetails->id])->get()->toArray();
            foreach ($userDetailAlert as $item) {
                $alertDetails[$item['meta_key']] = [
                    'sms' => $item['sms'],
                    'mobile' => $item['mobile'],
                    'email' => $item['email'],
                ];
            }
        }
        return view('frontauth/settings', compact(['userDetails', 'alertDetails']));
    }

    public function settingUpdate(UserDetailsUpdateRequest $request)
    {
        $user = auth::user();
        $result = $this->authService->settingUpdate($request->all(), $user);
        return redirect()->route('settings')->with('success', 'User details Updated Successfully');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route("login")->with('success', 'Logged out');
    }
}
