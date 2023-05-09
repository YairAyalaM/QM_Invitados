<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SortController extends Controller
{
    //
    public function posts(Request $request){
        $position =1;
        $sorts = $request->get('sorts');
        foreach($sorts as $sort){
            $post = User::find($sort);
            $post->position = $position;
            $post->save();
            
            $position++;
        }
    }
}