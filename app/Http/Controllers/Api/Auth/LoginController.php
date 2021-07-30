<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse|object
     */
    public function login(Request $request)
    {
        // Check user in database
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return response()
                ->json(['errors' => [ 1 => 'User not found']])
                ->setStatusCode(422);
        }

        // Check credentials
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()
                ->json(['errors' => [2 =>'Credentials not match']])
                ->setStatusCode(422);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        // Remove current access token
        return $request->user()->currentAccessToken()->delete();
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function getUserFromToken(Request $request): UserResource
    {
        return new UserResource($request->user());
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {

    }

    public function resetPassword(ResetPasswordRequest $request)
    {

    }
}
