<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Filter;
use App\Models\FilterOption;
use Illuminate\Http\Request;

class FilterOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filterOptions = FilterOption::with('filter')->paginate(15);

        return view('admin.filter-options.index', compact('filterOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filters = Filter::pluck('name_ar', 'id');
        return view('admin.filter-options.create', compact('filters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|unique:filter_options',
            'name_ar'   => 'required|unique:filter_options',
            'filter_id' => 'required|exists:filters,id',
        ]);

        $filterOption = new FilterOption();
        $filterOption->fill($request->all());
        $filterOption->save();

        return redirect()->action('Admin\FilterOptionController@index');

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
        $filterOption = FilterOption::find($id);
        $filters      = Filter::pluck('name_ar', 'id');

        return view('admin.filter-options.edit', compact(['filterOption', 'filters']));

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

        $request->validate([
            'name'      => 'required|unique:filter_options,name,' . $id,
            'name_ar'   => 'required|unique:filter_options,name_ar,' . $id,
            'filter_id' => 'required|exists:filters,id',
        ]);

        $filterOption = FilterOption::find($id);
        $filterOption->update($request->all());
        $filterOption->save();

        return redirect()->action('Admin\FilterOptionController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filterOption = FilterOption::find($id);
        $filterOption->delete();
        return response(['url' => 'filter-options']);
    }
}
