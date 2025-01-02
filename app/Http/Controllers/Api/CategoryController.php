<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        try{
            $categories = Category::all();
            return response()->json($categories);
        }catch(Exception $e){
            return response()->json($e);
        }
    }
}
