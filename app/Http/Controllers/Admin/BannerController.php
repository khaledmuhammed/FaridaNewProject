<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::paginate(15);
        return view('admin.banners.index', [
            'banners' => $banners,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required|string',
            'size'  => 'required|numeric',
        ])->validate();
        $banner = new Banner();
        $banner->fill($request->all());
        $banner->save();


        if ($request->hasFile('imgs')) {
            //imgs has all request images
            $files = $request->file('imgs');

            //to take one by one
            foreach ($files as $i => $file) {
                $width  = getImageSize($file)[0]; //the height is second element of getImageSize(), the width is first
                $height = getImageSize($file)[1]; //the height is second element of getImageSize(), the width is first
                $banner->addMedia($file)->setFileName(md5_file($file) . rand(1, 999999) . "." . $file->extension())
                       ->withCustomProperties(['link'   => $request->link[$i],
                                               'sort'   => $request->sort[$i],
                                               'width'  => $width,
                                               'height' => $height])
                       ->toMediaCollection('banners');
            }
        }


        return redirect()->action('Admin\BannerController@index');
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

        $banner = Banner::find($id);
        return view('admin.banners.edit', [
            'banner' => $banner,
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
            'title' => 'required|string',
            'size'  => 'required|numeric',
        ])->validate();
        $banner = Banner::find($id);
        $banner->update($request->all());

        if ($request->hasFile('imgs')) {
            //imgs has all request images
            $files = $request->file('imgs');

            //to take one by one
            foreach ($files as $i => $file) {
                $width  = getImageSize($file)[0];
                $height = getImageSize($file)[1];
                $banner->addMedia($file)->setFileName(md5_file($file) . rand(1, 999999) . "." . $file->extension())
                       ->withCustomProperties(['link' => $request->link[$i]
                           , 'sort'                   => $request->sort[$i]
                           , 'width'                  => $width
                           , 'height'                 => $height])
                       ->toMediaCollection('banners');
            }
        }


        return redirect()->action('Admin\BannerController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        return back();
    }

    public function updateMedia(Request $request, $banner_id, $media_id)
    {
        $banner = Banner::find($banner_id);
        $media  = $banner->getMedia('banners')->find($media_id);
        $media->setCustomProperty('link', $request->link);
        $media->setCustomProperty('sort', $request->sort);
        $media->save();
        return response([]) ;
    }

    public function deleteMedia($banner_id, $media_id)
    {
        $banner = Banner::find($banner_id);
        $media  = $banner->getMedia('banners')->find($media_id);
        if ($media) {
            $media->delete();
            return response([]);
        }
    }

    public function getPositionableBanner($id)
    {
        return Banner::with('media')->find($id);
    }
}
