<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Response;
use Exception;
use App\User;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('user', 'password');
        $token = JWTAuth::attempt($credentials);
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token) {
                return response()->json(['error' => 'Credenciales incorrectas'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'No se pudo ingresar'], 500);
        }
    
        // all good so return the token
        return response()->json(compact('token'));
    }

    public function check()
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['authenticated' => false]);
        }
        return response(['authenticated' => true]);
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 401);
        }
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    }

    public function roles(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('user', 'password');
        $token = JWTAuth::attempt($credentials);
        try {
            // attempt to verify the credentials and create a token for the user
            if (!$token) {
                return response()->json(['error' => 'Credenciales incorrectas'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'No se pudo ingresar'], 500);
        } 
        // all good so return the roles
        $u = User::with('rol')
        ->where('user', '=', $request->user)->get();
		#dd($u);
        return['u' => $u];
    }

}
