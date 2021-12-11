<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\camps;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Requests\User\Checkout\Store;
use App\Mail\Checkout\AfterCheckout;
use Illuminate\Support\Facades\Auth;
use Mail;
use Psy\Util\Str;
use Midtrans;

class CheckoutController extends Controller
{



    public function __construct()
    {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, camps $camp)
    {

        //validation landing page untuk menampilkan error jika sudah melakukan checkout pada course
        if ($camp->isRegistered) {
            $request->session()->flash('error', "You Already registered on {$camp->title} camp.");
            return redirect(route('user.dashboard'));
        }


        //untuk menampilkan apa yang sudah di checkout
        return view('checkout.create', [
            'camp' => $camp
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request, camps $camp)
    {

        //mapping request data
        $data = $request->all();

        $data['user_id'] = Auth::id(); // -> For Secure data
        $data['camp_id'] = $camp->id;

        //update data user 

        $user = Auth::user();
        $user->email = $data['email'];
        $user->nama  = $data['nama'];
        $user->occupation = $data['occupation'];
        $user->save();


        //create checkout
        $checkout = Checkout::create($data);
        $this->getSnapRedirect($checkout);
        // return $checkout;

        Mail::to(Auth::user()->email)->send(new AfterCheckout($checkout));

        return redirect(route('checkout.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }

    public function success()

    {
        //untuk menampilkan halaman checkout success
        return view('checkout.success');
    }

    public function invoice(Checkout $checkout)
    {
        return view('testing');
    }

    //midtrans Handler

    public function getSnapRedirect(Checkout $checkout)
    {
        $orderID = $checkout->id . '-' . Str::random(5);
        $price = $checkout->Camp->price * 1000;
        $checkout->midtrans_booking_code = $orderID;
        $transaction_details = [
            'order_id' => $orderID,
            'gross_amount' => $price,

        ];

        $item_details[] = [
            'id' => $orderID,
            'price' => $price,
            'quantity' => 1,
            'name' => "Payment for {$checkout->Camp->title} Camp.",

        ];

        $userData = [
            'first_name' => $checkout->User->nama,
            'last_name' => "",
            'address' => $checkout->User->address,
            'city'  => "",
            'postal_code' => "",
            'phone' => $checkout->User->phone,
            'country_code' => "IDN",

        ];

        $customers_details = [
            'first_name' => $checkout->User->nama,
            'last_name' => "",
            'email' => $checkout->User->email,
            'phone ' => $checkout->User->phone,
            'billing_address' => $userData,
            'shipping_address' => $userData,
        ];

        $midtrans_params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customers_details,
            'item_details' => $item_details,
        ];

        try {
            // get snapp payment page url
            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
            $checkout->midtrans_url = $paymentUrl;
            $checkout->save();

            return $paymentUrl;
        } catch (Execption $e) {
            return false;
        }
    }
}
