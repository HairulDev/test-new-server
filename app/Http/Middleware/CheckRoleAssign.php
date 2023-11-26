<?php

namespace App\Http\Middleware;

use App\Helpers\JWTHelper;
use App\Http\Controllers\API\GeneralFuncController;
use Closure;
use Illuminate\Http\Request;

class CheckRoleAssign
{
    public function handle(Request $request, Closure $next)
    {
        $decoded = JWTHelper::decodeToken($request);
        if (isset($decoded->preferred_username)) {
            $email = $decoded->preferred_username;
            $generalFuncController = new GeneralFuncController();
            $getUserResponse = $generalFuncController->getUserRole($email);
            $response = json_decode($getUserResponse->getContent());

            if (isset($response->data) && isset($response->data->Roles)) {
                $roles = $response->data->Roles;
                foreach ($roles as $role) {
                    return $next($request);
                }
            }

            return response()->json([
                'message' => "Your account doesn't have access",
                'status' => false,
            ], 401);
        }

        $data = $decoded->getData();

        return response()->json([
            'message' => $data->message,
            'status' => $data->status,
        ], 401);
    }
}
