<?php

namespace App\Http\Middleware;

use App\Helpers\JWTHelper;
use App\Http\Controllers\API\GeneralFuncController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $roleUser): Response
    {
        $decoded = JWTHelper::decodeToken($request);

        if (! empty($decoded)) {
            $email = $decoded->preferred_username;
            $generalFuncController = new GeneralFuncController();
            $getUserResponse = $generalFuncController->getUserRole($email);
            $response = json_decode($getUserResponse->getContent());

            if (! empty($response) && isset($response->data) && isset($response->data->Roles)) {
                $roles = $response->data->Roles;
                foreach ($roles as $role) {
                    if ($role->Role_Name === $roleUser) {
                        return $next($request);
                    }
                }
            }
        }

        return response()->json([
            'message' => "You don't have authorization",
            'status' => false,
        ], 401);
    }
}
