<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Auth, Validator;

class UserController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user      = User::with('city')->find(Auth::id());
        $addresses = $user->addresses()->with('city.country','district')->latest()->get();
        return view('frontend.user.index', compact(['user', 'addresses']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->except(['password'])); 
        if (!empty($request['password'])) {
            $validator = Validator::make($request->all(), [
                'password'  => 'string|min:6',
            ])->validate();
            $user->password = bcrypt($request['password']);
        }
        $user->save();
        return ['status' => 1];
    }
}
