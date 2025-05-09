<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemUnit;
use Illuminate\Http\Request;

class ItemUnitController extends Controller
{

    public function list()
    {
        $itemUnits = ItemUnit::all();
        return response()->json($itemUnits);
    }
}
