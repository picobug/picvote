<?php
namespace App\Http\Controllers\Api;
// Copyright (c) 2017 Julian Prasetyo <picobug.jp@gmail.com>
// 
// This software is released under the MIT License.
// https://opensource.org/licenses/MIT
use App\Human;
use App\Http\Resources\Human as HumanResource;

class HumanController extends Controller {
    public function show(){
        return HumanResource::collection(Human::all());
    }
}