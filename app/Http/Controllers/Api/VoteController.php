<?php
namespace App\Http\Controllers\Api;
// Copyright (c) 2017 Julian Prasetyo <picobug.jp@gmail.com>
// 
// This software is released under the MIT License.
// https://opensource.org/licenses/MIT
use App\Vote;
use App\Http\Resources\Vote as VoteResource;
use Illuminate\Http\Request;

class VoteController extends Controller {
    public function store(Request $request)
    {
        // Validate the request...

        $vote = new Vote;

        $vote->vote = $request->vote;
        $vote->category_id = $request->category_id;
        $vote->human_id = $request->human_id;

        if($vote->save()){
            return new VoteResource($vote);
        }
        return false;
    }
    public function show(){
        return VoteResource::collection(Vote::all());
    }
}