<?php

namespace App\Http\Controllers\User;


use App\Models\Rating;
use Auth;
use Illuminate\Http\Request;
use Validator;

class RatingController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Rating
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'rating'     => 'required|numeric|max:5',
            'comment'    => 'string',
            'product_id' => 'numeric|exists:products,id',
        ])->validate();

        $rating = new Rating();
        $rating->fill($request->all());
        $rating->approved = 0;
        $rating->user_id  = Auth::id();
        $rating->save();

        return $rating;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return Rating|Rating[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'rating'     => 'required|numeric|max:191',
            'comment'    => 'string',
            'product_id' => 'numeric|exists:products,id',
        ])->validate();

        $rating = Rating::find($id);
        $rating->update($request->except('approved'));
        $rating->approved = 0;
        $rating->save();

        return $rating;
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
        $rating = Rating::find($id);
        $rating->delete();
        return response(['url' => 'ratings']);
    }
}
