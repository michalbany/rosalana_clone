<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Notification;

class LikeController extends Controller
{
    public function like(Request $request, $postId)
    {
        $userId = auth()->user()->id;
        $like = Like::firstOrCreate(['user_id' => $userId, 'post_id' => $postId]);

        // Zvýšení bodů uživatele za dání like
        $liker = User::find($userId);
        $liker->rank_points += 1;
        $liker->save();

        $post = Post::find($postId);
        // Zvýšení bodů autora za like na jeho příspěvek
        $postAuthor = User::find($post->user_id);
        $postAuthor->rank_points += 2;
        $postAuthor->save();

        // Vytvoření notifikace
        if ($postAuthor->id !== $userId) {
            
            $notification = new Notification;
            $notification->user_id = $postAuthor->id;
            $notification->type = 'like';
            $notification->data = json_encode([
                'reason_user_id' => $userId,
                'post_id' => $postId,
            ]);
            $notification->save();
        }

        $likes = $post->likes->count();
        $unlikeUrl = route('post.unlike', $post->id);

        return response()->json([
            'likes' => $likes,
            'unlikeUrl' => $unlikeUrl,
        ]);
    }

    public function unlike(Request $request, $postId)
    {
        $userId = auth()->user()->id;
        $like = Like::where('user_id', $userId)->where('post_id', $postId)->first();
        if ($like) {
            $like->delete();
        }

        // Snížení bodů uživatele za zrušení like
        $liker = User::find($userId);
        $liker->rank_points -= 1;
        $liker->save();

        $post = Post::find($postId);
        // Snížení bodů autora příspěvku za ztrátu like
        $postAuthor = User::find($post->user_id);
        $postAuthor->rank_points -= 2;
        $postAuthor->save();

        $likes = $post->likes->count();
        $likeUrl = route('post.like', $post->id);

        return response()->json([
            'likes' => $likes,
            'likeUrl' => $likeUrl,
        ]);
    }
}

