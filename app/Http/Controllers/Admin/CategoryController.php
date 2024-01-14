<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Filter;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::paginate(15)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create', [
            'categories' => Category::all(),
            'categories' => Category::pluck('name', 'id'),
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
            'name'      => 'required|unique:categories|max:255',
            'is_active' => 'boolean',
            // 'thumbnail' => 'required_without:super_category_id',

        ])->validate();

        $category = new Category();
        $category->fill($request->all());
        $category->save();
        $file = $request->file('thumbnail');
        try {
            $category->addMedia($file)->setFileName(md5_file($file) . time() . "." . $file->extension())->toMediaCollection('category');
        } catch (FileCannotBeAdded $e) {
        }
        return redirect()->action('Admin\CategoryController@index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $category  = Category::with('filters:id')->find($id);
        $thumbnail = $category->getFirstMedia('category');
        $thumbnail ? $thumbnail = $thumbnail->getUrl() : $thumbnail = '';

        return view('admin.categories.edit', [
            'category'   => $category,
            'thumbnail'  => $thumbnail,
            'categories' => Category::pluck('name', 'id'),
            'filters'    => Filter::pluck('name_ar', 'id'),
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
            'name'      => 'required|unique:categories,name,' . $id . '|max:255',
            'is_active' => 'boolean',
        ])->validate();

        $category = Category::find($id);
        // if (!$request->filled('super_category_id') && $category->media->count() == 0) {
        //     Validator::make($request->all(), [
        //         'thumbnail' => 'required_without:super_category_id',
        //     ])->validate();
        // }
        $category->update($request->all());
        $category->save();
        if ($request->thumbnail) {
            $file = $request->file('thumbnail');
            // remove old picture
            $category->clearMediaCollection("category");
            // add the new picture
            $category->addMedia($file)->setFileName(md5_file($file) . time() . "." . $file->extension())->toMediaCollection('category');
        }
        $category->filters()->sync($request->filter_id);

        return redirect()->action('Admin\CategoryController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response(['url' => 'categories']);
    }
}
