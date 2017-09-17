<?php
namespace App\Http\Controllers\Api;
// Copyright (c) 2017 Julian Prasetyo <picobug.jp@gmail.com>
// 
// This software is released under the MIT License.
// https://opensource.org/licenses/MIT
use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller {
    public function show(){
        return CategoryResource::collection(Category::all());
    }
}