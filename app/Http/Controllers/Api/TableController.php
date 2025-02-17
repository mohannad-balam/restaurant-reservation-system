<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Exception;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        try{
            $tables = Table::orderBy('updated_at', 'DESC')->where('status','=','available')->get();
            return response()->json($tables,200);
        }catch(Exception $e){
            return response()->json("something went wrong", 400);
        }
    }
}
