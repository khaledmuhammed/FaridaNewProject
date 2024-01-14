<?php

namespace App\Http\Controllers\User;


use App\Models\MailList;
use Illuminate\Http\Request;
use Validator;

class MailListController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email|unique:mail_lists,email',
        ])->validate();

        $email = new MailList();
        $email->fill($request->all());
        $email->save();

        return redirect()->back();
    }
}
