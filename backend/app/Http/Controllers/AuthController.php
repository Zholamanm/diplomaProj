<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Auth as FirebaseAuth;
use Kreait\Firebase\Factory;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validatedData = $this->validateRequest($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->createUser($validatedData);

        return $this->respondWithToken($user, 201);
    }

    /**
     * Login a user and return a token.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $this->validateRequest($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $this->respondWithToken($user);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    /**
     * Logout a user (Revoke all tokens).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    /**
     * Validate the request with given rules.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $rules
     * @return array
     */
    protected function validateRequest(Request $request, array $rules)
    {
        return $request->validate($rules);
    }

    /**
     * Create a new user with validated data.
     *
     * @param array $validatedData
     * @return \App\Models\User
     */
    protected function createUser(array $validatedData)
    {
        return User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
    }

    /**
     * Generate a token and return a JSON response.
     *
     * @param \App\Models\User $user
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken(User $user, $statusCode = 200)
    {
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], $statusCode);
    }

//    public function loginWithGoogle(Request $request, FirebaseAuth $firebaseAuth)
//    {
//        $idTokenString = $request->input('idToken');
//
//        try {
//            $verifiedIdToken = $firebaseAuth->verifyIdToken($idTokenString);
//            $firebaseUser = $firebaseAuth->getUser($verifiedIdToken->claims()->get('sub'));
//
//            // Find user by email
//            $user = User::where('email', $firebaseUser->email)->first();
//
//            if (!$user) {
//                // Create new user if not exists
//                $user = User::create([
//                    'name' => $firebaseUser->displayName ?? 'No Name',
//                    'email' => $firebaseUser->email,
//                    // 'firebase_uid' => $firebaseUser->uid, // optional
//                ]);
//            }
//
//            // Optionally update fcm_token here if sent from frontend
//
//            $token = $user->createToken('api-token')->plainTextToken;
//
//            return response()->json([
//                'email' => $user->email,
//                'password' => '123456',
//                'token' => $token,
//            ]);
//        } catch (\Exception $e) {
//            return response()->json(['error' => 'Unauthorized'], 401);
//        }
//    }

    public function loginWithGoogle(Request $request)
    {
        $idTokenString = $request->input('idToken');
        try {
            $firebase = (new Factory)
                ->withServiceAccount(env('FIREBASE_CREDENTIALS'))
                ->createAuth();

            $firebaseAuth = $firebase;

            $verifiedIdToken = $firebaseAuth->verifyIdToken($idTokenString);
            $firebaseUser = $firebaseAuth->getUser($verifiedIdToken->claims()->get('sub'));

            $user = User::where('email', $firebaseUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $firebaseUser->displayName ?? 'No Name',
                    'password' => Hash::make('123456'),
                    'email' => $firebaseUser->email,
                ]);
            }

            return $this->respondWithToken($user);
        } catch (\Exception $e) {
            \Log::error('Firebase Auth error: ' . $e->getMessage());
            return response()->json(['error' => 'Unauthorized', 'details' => $e->getMessage()], 401);
        }
    }
}
