<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PreventDuplicateMessages
{

    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->user()->id;
        $messageId = $request->message()->id;

        $exists = DB::table('received_messages')
            ->where('user_id', $userId)
            ->where('message_id', $messageId)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'Duplicate message'], 409);
        }

        return $next($request);
    }
}
