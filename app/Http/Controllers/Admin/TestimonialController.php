<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::paginate(15);
        return view('admin.testimonials.index', compact('testimonials'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonials.create');

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
            'title'    => 'required|string',
            'comment'  => 'required|string',
            'username' => 'required|string',
        ])->validate();

        $testimonial = Testimonial::create($request->all());
        if ($request->hasFile('thumbnail')) {
            $this->addImage($testimonial, $request->file('thumbnail'));
        }

        return redirect()->action('Admin\TestimonialController@index');

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
        $testimonial = Testimonial::find($id);

        return view('admin.testimonials.edit', compact('testimonial'));

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
            'title'    => 'required|string',
            'comment'  => 'required|string',
            'username' => 'required|string',
        ])->validate();

        $testimonial = Testimonial::find($id);
        $testimonial->update($request->all());
        $testimonial->save();

        if ($request->hasFile('thumbnail')) {
            $this->addImage($testimonial, $request->file('thumbnail'));
        }

        return redirect()->action('Admin\TestimonialController@index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->delete();
        return back();

    }

    public function addImage(Testimonial $testimonial,\Illuminate\Http\UploadedFile $image)
    {
        $testimonial->clearMediaCollection('thumbnail');
        $testimonial->addMedia($image)->setFileName(md5_file($image) . rand(1, 999999) . "." . $image->extension())->toMediaCollection('thumbnail');
    }
}
