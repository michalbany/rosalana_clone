<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Models\Notification;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $comment = new Comment([
            'body' => $request->body,
            'user_id' => auth()->user()->id,
            'post_id' => $postId,
        ]);

        $comment->save();

        // Načtěte uživatele, který přidal komentář
        $user = User::find(auth()->user()->id);

        // Zvýšení bodů uživatele za přidání komentáře
        $user->rank_points += 1;
        $user->save();

        $postAuthor = Post::find($postId)->user_id;    


        //přidání notifikace
        if ($postAuthor !== $user->id){

            $notification = new Notification;
            $notification->user_id = $postAuthor;
            $notification->type = 'comment';
            $notification->data = json_encode([
                'reason_user_id' => $user->id,
                'post_id' => $postId,
            ]);
            $notification->save();
        }

        // Zvýšení bodů autora příspěvku za komentář
        if ($postAuthor !== $user->id){
            $postAuthor = User::find($postAuthor);
            $postAuthor->rank_points += 2;
            $postAuthor->save();
        }

        // Vraťte JSON odpověď s potřebnými informacemi
        return response()->json([
            'success' => true,
            'comment_id'=> $comment->id,
            'body' => $comment->body,
            'user_id' => $comment->user_id,
            'post_id' => $comment->post_id,
            'created_at' => $comment->created_at->toDateTimeString(),
            'user' => [
                'name' => $user->name,
                'profile_image' => $user->profile_image,
            ],
        ]);
    }
}
