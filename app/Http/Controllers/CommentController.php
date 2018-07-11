<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Services\DBClasss;
use Validator;
class CommentController extends Controller
{
    public function addComment(Request $request, DBClasss $dbclass)
    {
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string|max:100',
            'Comment' => 'required',
            'film_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        return response($dbclass->addComment($request),200);
    }
}
