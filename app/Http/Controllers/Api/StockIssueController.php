<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StockIssue;
use App\Models\StockIssueItem;
use Illuminate\Http\Request;

class StockIssueController extends Controller
{
    public function list(Request $request)
    {
        $stockIssues = StockIssue::with(['company', 'account'])->get();
        return response()->json([
            'message' => 'Transactions retrieved successfully',
            'data' => $stockIssues
        ]);
    }

    public function store(Request $request)
    {
        if ($request->Code == '<<AutoGenerate>>') {
            $month = date('m');
            $day = date('d');
            $code = $month . $day . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4));
        } else {
            $code = $request->Code;
        }
        $data = [
            'company_id' => $request->Company,
            'company_name' => $request->CompanyName,
            'code' => $code,
            'date' => $request->Date,
            'account_id' => $request->Account,
            'account_name' => $request->AccountName,
            'note' => $request->Note,
        ];
        $stockIssue = StockIssue::create($data);
        return response()->json([
            'message' => 'Transaction created successfully',
            'data' => $stockIssue
        ]);
    }

    public function update(Request $request, $id)
    {
        $stockIssue = StockIssue::findOrFail($id);
        $data = [
            'company_id' => $request->Company,
            'company_name' => $request->CompanyName,
            'code' => $request->Code,
            'date' => $request->Date,
            'account_id' => $request->Account,
            'account_name' => $request->AccountName,
            'note' => $request->Note,
        ];
        $stockIssue->update($data);
        return response()->json([
            'message' => 'Transaction updated successfully',
            'data' => $stockIssue
        ]);
    }

    public function delete($id)
    {
        $stockIssue = StockIssue::findOrFail($id);
        if ($stockIssue->stockIssueItems()->exists()) {
            $stockIssue->stockIssueItems()->delete();
        }
        $stockIssue->delete();
        return response()->json([
            'message' => 'Transaction deleted successfully'
        ]);
    }

    public function detail(string $stockIssueId)
    {
        $stockIssue = StockIssue::with(['stockIssueItems'])->findOrFail($stockIssueId);
        return response()->json([
            'message' => 'Items retrieved successfully',
            'data' => $stockIssue
        ]);
    }


    public function storeDetail(Request $request, string $stockIssueId)
    {
        $data = [
            'item_id' => $request->Item,
            'item_name' => $request->ItemName,
            'quantity' => $request->Quantity,
            'item_unit_id' => $request->ItemUnit,
            'item_unit_name' => $request->ItemUnitName,
            'note' => $request->Note,
        ];
        $stockIssueItem = StockIssue::findOrFail($stockIssueId)->stockIssueItems()->create($data);
        return response()->json([
            'message' => 'Item created successfully',
            'data' => $stockIssueItem
        ]);
    }

    public function updateDetail(Request $request, string $stockIssueId,string $id)
    {
        $stockIssueItem = StockIssueItem::findOrFail($id);
        $data = [
            'item_id' => $request->Item,
            'item_name' => $request->ItemName,
            'quantity' => $request->Quantity,
            'item_unit_id' => $request->ItemUnit,
            'item_unit_name' => $request->ItemUnitName,
            'note' => $request->Note,
        ];
        $stockIssueItem->update($data);
        return response()->json([
            'message' => 'Item updated successfully',
            'data' => $stockIssueItem
        ]);
    }

    public function deleteDetail(string $stockIssueId, string $id)
    {
        $stockIssueItem = StockIssueItem::findOrFail($id);
        $stockIssueItem->delete();
        return response()->json([
            'message' => 'Item deleted successfully'
        ]);
    }
}
