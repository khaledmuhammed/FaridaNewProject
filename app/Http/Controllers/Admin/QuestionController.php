<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Question;
use Auth;
use Illuminate\Http\Request;
use Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('product', 'user')->paginate(15);
        return view('admin.questions.index', [
            'questions' => $questions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::pluck('name', 'id');
        return view('admin.questions.create', [
            'products' => $products,
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
            'text'       => 'required|string',
            'product_id' => 'required|exists:products,id',
        ])->validate();

        $question = new Question();
        $question->fill($request->all());
        $question->user_id = Auth::user()->id;
        $question->save();

        return redirect()->action('Admin\QuestionController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product  = Product::pluck('name', 'id');
        $question = Question::find($id);
        return view('admin.questions.show', [
            'product'  => $product,
            'question' => $question,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::with('product')->find($id);
        return view('admin.questions.edit', [
            'question' => $question,
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
            'text'       => 'required|string',
            'product_id' => 'required|exists:products,id',
        ])->validate();

        $question = Question::find($id);
        $question->update($request->all());
        $question->save();

        return redirect()->action('Admin\QuestionController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        return response(['url' => 'questions']);
    }
}
