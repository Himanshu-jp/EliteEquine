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
use App\Models\Community;
use App\Models\Product;
use App\Models\UserDetailAlert;
use App\Models\UserDetails;
use App\Models\Favorite;
use App\Services\Front\AuthService;
use Carbon\Carbon;
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
        $products = Product::with(['productDetail', 'image', 'disciplines', 'height', 'sex', 'category'])
            ->where(
                ['deleted_at' => null, 'user_id' => $user->id]
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
            $remember = $request->filled('remember');
            Auth::attempt($credentials, $remember);
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
        $settingDetails = UserDetails::where('user_id',$user->id)->where('phone','!=',null)->first();
        if(!$settingDetails)
        {
            return redirect()->route('settings');
        }
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

        if(Auth::user()->is_subscribed  != '1'){
        return redirect()->route('subscription')->with('success', 'User details Updated Successfully');
        }
        return redirect()->route('settings')->with('success', 'User details Updated Successfully');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route("login")->with('success', 'Logged out');
    }
    public function mapboxevent(Request $request)
    {
        $categoryId = $request->query('category');

        if (!$categoryId) {
            return response()->json([
                'error' => 'Category parameter is required'
            ], 400);
        }
           $markerImageTrail="Horse Red.png";
         $markerImage="Horse Blue.png";
        if($categoryId==1)
        {
            $markerImageTrail="Horse Red.png";
             $markerImage="Horse Blue.png";
        }
        else if($categoryId==2)
        {
            $markerImageTrail="Equipment Red.png";
             $markerImage="Equipment Blue.png";
        }
        else if($categoryId==3)
        {
            $markerImage="Barn and housing Blue.png";
             $markerImageTrail="Barn and housing Red.png";
        }
         elseif($categoryId==4)
        {
            $markerImageTrail="Services Jobs Red.png";
             $markerImage="Services Jobs Blue.png";
        }
         elseif($categoryId==5)
        {
            $markerImage="Community Blue.png";
             $markerImageTrail="Community Red.png";
        }
  
      $latitude=$request->latitude ?? 26.836992;
        $longitude= $request->longitude ?? 75.769446;
        if (in_array($categoryId, [1, 2, 3, 4])) {
            $data = Product::with(['user', 'productDetail', 'image'])
                ->where(['product_status' => 'live', 'deleted_at' => null])
                ->where('category_id', $categoryId);
            if ($request->name) {
                $data = $data->where("title", 'like', "%" . $request->name . "%");
            }
            if ($request->latitude && $request->longitude) {
                $latitude = $request->latitude;
                $longitude = $request->longitude;
                $radius = 100;

                $data->whereHas('productDetail', function ($query) use ($latitude, $longitude, $radius) {
                    $haversine = "(6371 * acos(cos(radians($latitude)) 
                        * cos(radians(latitude)) 
                        * cos(radians(longitude) - radians($longitude)) 
                        + sin(radians($latitude)) 
                        * sin(radians(latitude))))";

                    $query->select('*')
                        ->whereRaw("$haversine < ?", [$radius]);
                });
            }
            if ($request->date) {
                $searchDate=date("Y-m-d",strtotime($request->date));
                $data = $data->whereDate("created_at", $searchDate);
            }
            $data = $data->orderBy('id', 'desc')
                ->get();
        $html = view("homemapview", compact("data",'latitude','longitude','markerImage','markerImageTrail'))->render();
        } elseif ($categoryId == 5) {
            $now = Carbon::now();
  $markerImage="Community Blue.png";
             $markerImageTrail="Community Red.png";
            $data = Community::with('user')
                ->whereNull('deleted_at') // or use softDeletes if applicable
                ->where(function ($query) use ($now) {
                    $query->where('date', '>', $now->toDateString())
                        ->orWhere(function ($q) use ($now) {
                            $q->where('date', $now->toDateString())
                                ->where('time', '>=', $now->toTimeString());
                        });
                })
                ->orderBy('date', 'asc')
                ->orderBy('time', 'asc')
                ->get();
                  $html = view("homemapviewcommunit", compact("data",'latitude','longitude','markerImage','markerImageTrail'))->render();
        }
      
     
      
        // return $html;
     
        return response()->json([
            'html' => $html,
           

        ]);
    }
}
