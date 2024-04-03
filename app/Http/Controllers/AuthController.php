<?php
namespace App\Http\Controllers;

use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rif' => 'required|string|max:255|unique:enterprises',
            'owner_name' => 'required|string|max:255',
            'owner_lastname' => 'required|string|max:255',
            'owner_dni' => 'required|string|max:255',
            'owner_phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:enterprises',
            'password' => 'required|string|confirmed|min:8',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $enterprise = Enterprise::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'Enterprise successfully registered',
            'enterprise' => $enterprise
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        /** @var Illuminate\Support\Facades\Auth */
        $auth = auth('api');
        return $this->createNewToken($auth->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        /** @var Illuminate\Support\Facades\Auth */
        $auth = auth('api');
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $auth->factory()->getTTL() * 60,
            'user' => $auth->user()
        ]);
    }
}