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
 *
 *              @OA\Property(
 *                  property="Id",
 *                  description="ID of the user",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="name",
 *                  description="user name of the user",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="user_Description",
 *                  description="user description of the user",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="Access",
 *                  description="Access by of the user",
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
 *
 * @OA\Put(
 *      path="/api/user/{id}",
 *      operationId="updateUser",
 *      tags={"users"},
 *      summary="Update a user",
 *      description="Update a user",
 *
 *      @OA\Parameter(
 *          name="id",
 *          description="ID of the user",
 *          required=true,
 *          in="path",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\RequestBody(
 *          required=true,
 *
 *          @OA\JsonContent(
 *              type="object",
 *
 *              @OA\Property(
 *                  property="user_Name",
 *                  description="user name of the user",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="user_Description",
 *                  description="user description of the user",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="Access",
 *                  description="Access by of the user",
 *                  type="string",
 *              ),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="user updated successfully",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *      ),
 * )
 *
 * @OA\Get(
 *      path="/api/user",
 *      operationId="getUsers",
 *      tags={"users"},
 *      summary="Get users",
 *      description="Get a list of users with optional pagination and search",
 *
 *      @OA\Parameter(
 *          name="limit",
 *          description="Number of users to retrieve per page",
 *          required=false,
 *          in="query",
 *
 *          @OA\Schema(
 *              type="integer",
 *              default=10,
 *              minimum=1,
 *              maximum=100
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="page",
 *          description="Page number of the users",
 *          required=false,
 *          in="query",
 *
 *          @OA\Schema(
 *              type="integer",
 *              default=1,
 *              minimum=1
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="search",
 *          description="Search to filter users",
 *          required=false,
 *          in="query",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="orderBy",
 *          description="Order by users",
 *          required=false,
 *          in="query",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Parameter(
 *          name="orderDirection",
 *          description="Order direction asc or desc",
 *          required=false,
 *          in="query",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="users retrieved successfully",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *      ),
 * )
 *
 * @OA\Get(
 *      path="/api/user/{id}",
 *      operationId="getUser",
 *      tags={"users"},
 *      summary="Get a user",
 *      description="Get a user with id",
 *
 *      @OA\Parameter(
 *          name="id",
 *          description="ID of the user",
 *          required=false,
 *          in="path",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="user retrieved successfully",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *      ),
 * )
 *
 * @OA\Delete(
 *      path="/api/user/{id}",
 *      operationId="deleteduser",
 *      tags={"users"},
 *      summary="Delete a user",
 *      description="Delete an existing user with ID",
 *
 *      @OA\Parameter(
 *          name="id",
 *          description="ID of the user",
 *          required=true,
 *          in="path",
 *
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="user deleted successfully",
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request",
 *      ),
 * )
 *
 * @OA\Get(
 *      path="/api/user-access-user",
 *      operationId="getUserAccessuser",
 *      tags={"users"},
 *      summary="Get user access user",
 *      description="Get users",
 *
 *      @OA\Response(
 *          response=200,
 *          description="User access user retrieved successfully",
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
