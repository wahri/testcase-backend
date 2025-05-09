<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemAccountGroup;
use Illuminate\Http\Request;

class ItemAccountGroupController extends Controller
{
    public function list(Request $request)
    {
        $itemAccountGroups = ItemAccountGroup::all();
        return response()->json($itemAccountGroups);
    }
}
