<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    public function getTypeByName(string $name)
    {
        $itemTypes = ItemType::where('name', $name)->first();
        return response()->json($itemTypes);
    }
}
