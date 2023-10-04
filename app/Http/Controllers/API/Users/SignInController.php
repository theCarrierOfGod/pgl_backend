<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SignInController extends Controller
{
    private function generateRandomString($length = 10){
        $characters = '012345678901234567890123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function signIn(Request $request)
    {
        try {
            $username = $request->input('username');
            $UserModel = User::where('username', $username)->first();
            if (empty($UserModel)) {
                return response()->json(['error' => [
                        'source' => 'username',
                        'message' => 'invalid username supplied'
                        ]
                    ])
                        ->header('Content-Type', 'application/json')
                        ->header('Access-Control-Allow-Origin', '*');
            }
            
            return response()->json([
                    'success' => true,
                    'username' => $username
                ])
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found.'], 404)
                ->header('Content-Type', 'application/json')
                ->header('Access-Control-Allow-Origin', '*');
        }
    }
}
