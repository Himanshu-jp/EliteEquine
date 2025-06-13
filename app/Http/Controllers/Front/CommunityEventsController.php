<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\CommentRequest;
use App\Http\Requests\Front\CommunityEventsRequest;
use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\EventAttendees;
use App\Services\Front\CommunityEventsService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Stripe\Stripe;
use Stripe\Checkout\Session;
Stripe::setApiKey(env('STRIPE_SECRET'));   


class CommunityEventsController extends Controller
{
    protected $communityEventsService;

    public function __construct(CommunityEventsService $communityEventsService)
    {
        $this->communityEventsService = $communityEventsService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $community = Community::with(['user','join'])->where(['user_id'=>$user->id,'deleted_at'=>null]);
        if ($request->filled('search')) {
            $community->where('title', 'like', '%' . $request->search . '%');
            $community->Orwhere('requirement', 'like', '%' . $request->search . '%');
            $community->Orwhere('location', 'like', '%' . $request->search . '%');
        }
        $community = $community->orderBy('id', 'desc');
        $community = $community->paginate(10)->appends($request->query());
        return view('frontauth/Community/index',compact('community'));

    }

    public function create()
    {
        return view('frontauth/Community/create');
    }

    public function store(CommunityEventsRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $forum = $this->communityEventsService->create($data,$user);

        return redirect()->route('community.index')->with('success', 'Community & Events created successfully.');
    }

    public function edit($id)
    {
        $community = Community::where('id',$id)->first();
        return view('frontauth/Community/create',compact('community'));
    }
    
    public function show($id)
    {
        $community = EventAttendees::with(['user','event'])->where(['event_id'=>$id,'deleted_at'=>null]);
        $community = $community->orderBy('id', 'desc');
        $community = $community->paginate(10);
        return view('frontauth/Community/show',compact('community'));
    }


    public function update(CommunityEventsRequest $request,$id)
    {        
        $data = $request->all();
        $result =  $this->communityEventsService->update($id, $data);
        return redirect()->route('community.index')->with('success', 'Community & Events updated successfully.');
    }

    public function destroy($id)
    {
        $this->communityEventsService->delete($id);
        return redirect()->route('community.index')->with('success', 'Community & Events deleted successfully.');
    }

    public function joinEvent($id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'To join this event, please log in to your account.');
        }
        $user = Auth::user();
        $exits = EventAttendees::where(['user_id'=>$user->id,'event_id'=>$id])->first();
        if($exits){
            return redirect()->back()->with('warning', "You're already a participant in this event.");
        }else{

            $event = Community::where(['id'=>$id])
                ->whereNull('deleted_at')
                ->whereDate('date', '>', Carbon::now())
                ->first();

            // -------- Here add stripe payment gateway to join this event---------------//          
            try {
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Laravel Stripe Payment',
                            ],
                            'unit_amount' => $event->price*100, // $10.00 in cents
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => route('event.success') . '?session_id={CHECKOUT_SESSION_ID}&event_id='.$id,
                    'cancel_url' => route('event.cancel') . '?session_id={CHECKOUT_SESSION_ID}&event_id='.$id,
                ]);
    
                return redirect($session->url, 303);
            } catch (Exception $e) {
                return back()->withErrors(['error' => 'Unable to create payment session: ' . $e->getMessage()]);
            }
        }
    }


    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $eventId = $request->query('event_id');

        if (!$sessionId) {
            return redirect()->back()->with('error', "Missing session ID. Payment failed.");
        }
        $user = Auth::user();        
        $session = Session::retrieve($sessionId);
    
        // Optional: fetch related payment intent
        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
 
        //--------Store the data into the db--------///
        $event = Community::where(['id'=>$eventId])
                ->whereNull('deleted_at')
                ->first();

        $data= [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'amount' => $event->price,
            'currency' => 'usd',
            'payment_status' => $paymentIntent->status,
            'stripe_session_id' => $session->id,
            'stripe_payment_intent' => $session->payment_intent
        ];

        $joinEvent = $this->communityEventsService->joinAnEvent($data);
        return redirect()->route('communityDetails',$eventId)->with('success', "Well done! You're now part of this event.");
    }


    //---------------------- Community & Events listing & details routes-----------------------//
    public function communityListing(Request $request)
    {
        return view('front/communityListing');
    }

    public function getCommunityDataTable(Request $request)
    {       
        $data = Community::with(['user'])
            ->whereNull('deleted_at')
            ->whereDate('date', '>', Carbon::now());

        $searchString = $request->search;
        if (!empty($searchString)) {
            $data = $data->where(function ($query) use ($searchString) {
                $query->where('title', 'like', "%$searchString%");
                // $query->orWhere('location', 'like', "%$searchString%");
            });
        }

        if (!empty($request->location)) {
            $location = $request->location;
            $data = $data->where(function ($query) use ($location) {
                    $query->where('location', 'like', "%$location%");
            });
        }

        if (!empty($request->date) && !empty($request->date)) {
            $date = !empty($request->date)
                ? Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d')
                : null;
            $data = $data->where(function ($query) use ($date) {
                $query->whereDate('date', '>=', $date)
                        ->whereDate('date', '<=', $date);
            });
        }

        if (!empty($request->minPrice) && !empty($request->maxPrice)) {
            $minPrice = $request->minPrice;
            $maxPrice = $request->maxPrice;
            $data = $data->where(function ($query) use ($minPrice, $maxPrice) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }

        //-------sorting---------//
        if (!empty($request->sort)) {
            $data->orderBy('price', $request->sort);
        } else {
            $data->orderBy('id', 'desc');
        }

        $limit = 20;
        if (!empty($request->limit)) {
            $limit = $request->limit;
        }


        $total = $data->count();
        $data = $data->paginate($limit); // Adjust per page as needed
        $viewMode = $request->view_mode;
        $html = view('front/communityCard', compact(['data','viewMode']))->render();
        $pagination = $data->withQueryString()->links('pagination::bootstrap-4')->render();

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'total' => $total
        ]);
    }

    public function communityDetails($id)
    {
        //------checking if user already register for an event----------///
        $attending=null;
        if (Auth::check()) {
            $user = Auth::user();
            $attending = EventAttendees::where(['user_id'=>$user->id,'event_id'=>$id])->first();
        }
        
        $community = Community::with(['user','join'])
            ->whereNull('deleted_at')
            ->whereDate('date', '>', Carbon::now());

        $community = $community->where(['deleted_at' => null, 'id' => $id]);
        $community = $community->orderBy('id', 'desc')->first(); // keep search on pagination links

        if(!$community){
            return redirect()->route('community-events')->with('error', 'This Events is no longer available.');
        }

       
        $moreAdd = Community::with(['user'])
            ->where('id', '!=', $id)
            ->where(['deleted_at' => null, 'user_id' => $community->user_id])
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

       

        return view('front/communityDetails', compact(['community', 'moreAdd','attending']));
    }


}
