<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Hapus refresh token lama (opsional)
        DB::table('refresh_tokens')->where('user_id', $user->id)->delete();

        // Buat token baru
        $accessToken = $user->createToken('access_token')->plainTextToken;
        $refreshToken = Str::random(60);

        DB::table('refresh_tokens')->insert([
            'user_id' => $user->id,
            'token' => hash('sha256', $refreshToken),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user = User::with('company')->find($user->id);

        return response()->json([
            'user' => $user,
            'company' => $user->company_id,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ]);
    }

    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => ['required']
        ]);

        $hashed = hash('sha256', $request->refresh_token);

        $tokenRecord = DB::table('refresh_tokens')->where('token', $hashed)->first();

        if (!$tokenRecord) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }

        $user = User::find($tokenRecord->user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Hapus token lama dan buat baru
        DB::table('refresh_tokens')->where('user_id', $user->id)->delete();

        $accessToken = $user->createToken('access_token')->plainTextToken;
        $newRefreshToken = Str::random(60);

        DB::table('refresh_tokens')->insert([
            'user_id' => $user->id,
            'token' => hash('sha256', $newRefreshToken),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $newRefreshToken,
            'token_type' => 'Bearer',
            'expires_in' => 3600
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
