<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Client::latest()->paginate(10);
        // dd($clients);
        return view('client.index')->with('clients', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name'     => ['required', 'max:255', 'string'],
            'username' => ['required', 'max:255', 'string', 'unique:clients'],
            'email'    => ['required', 'max:255', 'string', 'email', 'unique:clients'],
            'phone'    => ['max:255', 'string'],
            'country'  => ['max:255', 'string'],
            'avatar'   => ['image'],
            'status'   => ['not_in:none', 'string'],
        ]);

        $avatar = null;
        if (!empty($request->file('avatar'))) {
            $avatar = $request->file('avatar')->getClientOriginalName() . '-' . time();
            $request->file('avatar')->storeAs('public/uploads', $avatar);
        }

        Client::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'country'  => $request->country,
            'avatar'   => $avatar,
            'status'   => $request->status,
        ]);


        return redirect()->route('client.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
