<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemGroup;
use Illuminate\Http\Request;

class ItemGroupController extends Controller
{
    public function list(Request $request)
    {
        $itemGroups = ItemGroup::all();
        return response()->json($itemGroups);
    }
}
