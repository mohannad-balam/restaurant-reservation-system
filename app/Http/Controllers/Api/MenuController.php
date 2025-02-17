<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Exception;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(){
        try{
            $menus = Menu::all();
            return response()->json($menus);
        }catch(Exception $e){
            return response()->json("something went wrong", 400);
        }
    }
}
