<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function list(Request $request)
    {
        $item = Item::with([
            'company:id,name',
            'itemType:id,name',
            'itemGroup:id,name',
            'itemAccountGroup:id,name',
            'itemUnit:id,name',
        ])->withSum('stockIssueItems', 'quantity')->orderBy('created_at')->get();
        return response()->json([
            'message' => 'Item list retrieved successfully',
            'items' => $item,
        ]);
    }

    public function store(Request $request)
    {
        if($request->Code == '<<Auto>>'){
            $maxCode = Item::max('code');
            $code = str_pad($maxCode + 1, 5, '0', STR_PAD_LEFT);
        }else{
            $code = $request->Code;
        }

        $data = [
            'code' => $code,
            'label' => $request->Label,
            'company_id' => $request->Company,
            'item_type_id' => $request->ItemType,
            'item_group_id' => $request->ItemGroup,
            'item_account_group_id' => $request->ItemAccountGroup,
            'item_unit_id' => $request->ItemUnit,
            'is_active' => $request->boolean('IsActive', true),
        ];

        $item = Item::create($data);
        return response()->json([
            'message' => 'Item created successfully',
            'item' => $item,
        ]);
    }

    public function save(Request $request)
    {
        $item = Item::findOrFail($request->Oid);
        
        if($request->Code == '<<Auto>>'){
            $maxCode = Item::max('code');
            $code = str_pad($maxCode + 1, 5, '0', STR_PAD_LEFT);
        }else{
            $code = $request->Code;
        }

        $data = [
            'code' => $code,
            'label' => $request->Label,
            'company_id' => $request->Company,
            'item_type_id' => $request->ItemType,
            'item_group_id' => $request->ItemGroup,
            'item_account_group_id' => $request->ItemAccountGroup,
            'item_unit_id' => $request->ItemUnit,
            'is_active' => $request->boolean('IsActive', true),
        ];
        $item->update($data);
        $item->save();
        $item = Item::findOrFail($request->Oid);

        return response()->json([
            'message' => 'Item updated successfully',
            'item' => $item,
        ]);
    }

    public function delete(Request $request)
    {
        $item = Item::findOrFail($request->Oid);
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully',
        ]);
    }
}
