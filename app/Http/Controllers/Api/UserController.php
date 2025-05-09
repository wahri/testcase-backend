<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function detail($id)
    {
        $user = User::with('company')->findOrFail($id);
        return response()->json([
            'message' => 'User detail retrieved successfully',
            'user' => $user,
        ]);
    }
}
