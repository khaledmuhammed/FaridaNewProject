<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{City, User, Role, MailList};
use Illuminate\Http\Request;
use App\Exports\MailListExport;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::pluck('name_ar', 'id');
        $roles  = Role::pluck('name_ar', 'id');
        return view('admin.users.create', [
            'cities' => $cities,
            'roles'  => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6|confirmed',
            'city_id'    => 'required|exists:cities,id',
            'role_id'    => 'required|exists:roles,id',
            'gender'     => 'required|in:F,M',
            'mobile'     => 'required|string|unique:users,mobile',


        ])->validate();

        $user = new User();
        $user->fill($request->all());
        $user->save();
        // if ($request->mail_list) {
        //     $mailList        = new MailList;
        //     $mailList->email = $request->email;
        //     $mailList->save();
        // }
        
        session()->flash('success', 'تمت إضافة المستخدم بنجاح');
        return redirect()->action('Admin\UserController@index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user   = User::find($id);
        $cities = City::pluck('name_ar', 'id');
        $roles  = Role::pluck('name_ar', 'id');
        return view('admin.users.edit', [
            'user'   => $user,
            'cities' => $cities,
            'roles' => $roles,
        ]);
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
        Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email|unique:users,email,' . $id,
            'city_id'    => 'required|exists:cities,id',
            'role_id'    => 'required|exists:roles,id',
            'gender'     => 'required|in:F,M',
            'mobile'     => 'required|string|unique:users,mobile,' . $id,

        ])->validate();
        $user = User::find($id);
        $user->update($request->except(['password']));
        if (!empty($request['password'])) {
            $validator = Validator::make($request->all(), [
                'password'  => 'string|min:6|confirmed',
            ])->validate();
            $user->password = bcrypt($request['password']);
        }
        $user->save();

        session()->flash('success', 'تم تعديل بيانات المستخدم بنجاح');
        return redirect()->action('Admin\UserController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withCount('orders')->find($id);

        if (!$user->orders_count) {
            $user->delete();
        }
        //Todo: show alert for un-deletable users
        return back();
    }

    public function export() 
    {
        return Excel::download(new MailListExport, 'MailList-'.date('Y-m-d').'.xlsx');
    }
}
