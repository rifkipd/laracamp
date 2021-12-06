<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\camps;
use App\Models\Checkout;
use Illuminate\Http\Request;
use App\Http\Requests\User\Checkout\Store;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
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
            return redirect(route('dashboard'));
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
        return $request->all();
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
}
