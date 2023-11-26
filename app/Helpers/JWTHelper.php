<?php

namespace App\Helpers;

use \Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class JWTHelper
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function decodeToken(Request $request)
    {
        try {
            $header = $request->header('Authorization');
            // $token = str_replace('Bearer ', '', $header);
            $token = 'eyJleHBpcmVzX2luIjozMTU2MTkyMDAsInR5cCI6IkpXVCIsImFsZyI6IkhTMjU2In0.eyJhcHAiOiJUREMgQVBQIiwiY3JlYXRvciI6IlRIRSBESUdJVEFMIENFTExBUiIsInllYXIiOjIwMjN9.g1Gv2ZS3TY-jjFFnL9nIFNgtalvokc-Kw2rrf2KZ6a4';
            $cacheKey = 'decoded_token_'.$token;

            // // Cek token di cache
            // if (Cache::has($cacheKey)) {
            //     return Cache::get($cacheKey);
            // }

            $algorithm = 'HS256';
            $decoded = JWT::decode($token, 'TDC', $algorithm, null);
            // Cache::put($cacheKey, $decoded, intval(env('SET_TIME_CACHE'))); 
            var_dump($decoded);
            
            return $decoded;
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
            ], 401);
        }
    }
}
