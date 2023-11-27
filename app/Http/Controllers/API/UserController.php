<?php

namespace App\Http\Controllers\API;

use App\Helpers\JWTHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @OA\Post(
 *      path="/api/user",
 *      operationId="createUser",
 *      tags={"users"},
 *      summary="Create a user",
 *      description="Create a user",
 *
 *      @OA\RequestBody(
 *          required=true,
 *
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(
 *                  property="name",
 *                  description="user name of the user",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="email",
 *                  description="user email of the user",
 *                  type="string",
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="user created successfully",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *      ),
 * )
 */
class UserController extends Controller
{
    public function __construct()
    {
    }

    public function getUsers(Request $request)
    {
        try {
            // $secretKey = 'TDC';
            // $jwtHelper = new JWTHelper($secretKey);
            // $decodedToken = $jwtHelper->decodeToken($request);

            $limit = intval($request->query('limit', 10));
            $page = intval($request->query('page', 1));
            $search = $request->query('search');
            $orderBy = $request->query('orderBy', 'name');
            $orderDirection = $request->query('orderDirection', 'asc');

            $query = User::where('is_deleted', false);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
                });
            }

            $users = $query->orderBy($orderBy, $orderDirection)->paginate($limit, ['*'], 'page', $page);

            return response()->json([
                'message' => 'Users retrieved successfully',
                'status' => true,
                'data' => $users->items(),
                'pagination' => [
                    'total' => $users->total(),
                    'per_page' => $users->perPage(),
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function getUser($id)
    {
        try {
            $checkData = User::find($id);
            if ($checkData == null || empty($checkData)) {
                return response()->json([
                    'message' => 'User not found',
                    'status' => false,
                ], 404);
            }

            $user = User::where('Is_Deleted', false)->findOrFail($id);

            return response()->json([
                'message' => 'User retrieved successfully',
                'status' => true,
                'data' => $user,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function createUser(Request $request)
    {
        try {
            $name = $request->input('name');
            $email = $request->input('email');

            $time = Carbon::now('Asia/Jakarta')->toDateTimeString();

            $checkData = User::where([
                ['Email', $email], ['Is_Deleted', false],
            ])->first();
            if ($checkData || $checkData !== null) {
                return response()->json([
                    'message' => 'Email has registered',
                    'status' => false,
                ], 400);
            }

            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $user = new User();
            $user->id = Str::uuid();
            $user->name = $name;
            $user->email = $email;
            $user->created_at = $time;
            $user->is_deleted = false;

            $user->save();
            $status = 'Create';

            return response()->json([
                'message' => 'Create user successfully',
                'status' => true,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $checkData = User::find($id);
            if ($checkData == null || empty($checkData)) {
                return response()->json([
                    'message' => 'User not found',
                    'status' => false,
                ], 404);
            }

            $name = $request->input('name');
            $email = $request->input('email');

            $time = Carbon::now('Asia/Jakarta')->toDateTimeString();

            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $user = User::where('id', $id)->update([
                'name' => $name,
                'email' => $email,
                'updated_at' => $time,
            ]);

            return response()->json([
                'message' => 'Update user successfully',
                'status' => true,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => false,
            ], 500);
        }
    }

    public function delUser($id)
    {
        try {
            $time = Carbon::now('Asia/Jakarta')->toDateTimeString();
            $checkData = User::find($id);
            if ($checkData == null || empty($checkData)) {
                return response()->json([
                    'message' => 'User not found',
                    'status' => false,
                ], 404);
            }

            $user = User::where('id', $id)->update([
                'updated_at' => $time,
                'is_deleted' => true,
            ]);

            return response()->json([
                'message' => 'Delete user successfully',
                'status' => true,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => false,
            ], 500);
        }
    }
}
