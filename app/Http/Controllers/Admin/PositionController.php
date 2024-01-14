<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\FeaturedProduct;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = Position::all();
        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {

        $position->load('featuredProducts', 'banners');

        return view('admin.positions.edit', compact('position'));
    }

    public function getPositionables($name)
    {
        $position      = Position::where('name', $name)->first();
        $positionables = DB::table('positionables')->where('position_id', $position->id)->orderBy('sort')->get();
        return $positionables;
    }


    public function sort(Request $request, $id)
    {

        $position = Position::find($id);

        //Empty the position elements
        $position->featuredProducts()->sync([]);
        $position->banners()->sync([]);

        if ($request->positionables) {
            foreach ($request->positionables as $key => $positionable) {
                $arr   = explode("-", $positionable);
                $id    = $arr[0];
                $model = $arr[1];

                if ($model == 'FeaturedProduct') {
                    $position->featuredProducts()->attach($id, ['sort' => $key]);
                } elseif ($model == 'Banner') {
                    $position->banners()->attach($id, ['sort' => $key]);
                }
            }
        }

        return redirect()->action('Admin\PositionController@index');
    }

    public function positionsList()
    {

        $positionables = collect([]);
        //use model name here |------------| to be used in store functions
        $positionables->put('FeaturedProduct', FeaturedProduct::all());
        $positionables->put('Banner', Banner::all());
        return $positionables;
    }

}
