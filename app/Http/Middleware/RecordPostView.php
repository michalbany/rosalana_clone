<?php

namespace App\Http\Middleware;


use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordPostView
{
    public function handle(Request $request, Closure $next)
    {
        $postId = $request->route('id');
        $sessionKey = "post_viewed_{$postId}";

        $lastViewed = session($sessionKey, 0);
        $now = time();

        // Zaznamenej zhlédnutí, pokud od posledního zhlédnutí uplynulo alespoň 10 minut.
        if ($now - $lastViewed >= 10*60) {
            Post::where('id', $postId)->increment('views');
            session()->put($sessionKey, $now);
        }

        return $next($request);
    }
}
