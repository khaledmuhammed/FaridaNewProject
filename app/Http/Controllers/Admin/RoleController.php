<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::withCount('users')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name'    => 'required|string|unique:roles,name',
            'name_ar' => 'required|string|unique:roles,name_ar',
        ])->validate();

        $role          = new Role();
        $role->name    = $request->name;
        $role->name_ar = $request->name_ar;
        $role->save();

        return redirect()->action('Admin\RoleController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.roles.edit', [
            'role' => Role::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name'    => 'required|string|unique:roles,name,' . $id,
            'name_ar' => 'required|string|unique:roles,name_ar,' . $id,
        ])->validate();

        $role          = Role::find($id);
        $role->name    = $request->name;
        $role->name_ar = $request->name_ar;
        $role->save();

        return redirect()->action('Admin\RoleController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        try {
            $role->delete();
        } catch (\Exception $e) {

        }
        return response(['url' => 'roles']);
    }
}
