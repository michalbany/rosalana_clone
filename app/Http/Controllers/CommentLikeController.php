<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;

class CommentLikeController extends Controller
{
    public function like(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        
        // Zkontrolujte, zda uživatel již nelajkoval tento komentář
        $existingLike = CommentLike::where('user_id', auth()->user()->id)
            ->where('comment_id', $commentId)
            ->first();

        // Pokud uživatel již tento komentář lajkoval, vraťte JSON odpověď s chybou
        if ($existingLike) {
            return response()->json(['error' => 'Tento komentář už jste lajkovali.']);
        }

        $like = new CommentLike(['user_id' => auth()->user()->id]);
        $comment->likes()->save($like);

        // přidání notifikace
        $commentAuthor = Comment::find($commentId)->user_id;
        
        if ($commentAuthor !== auth()->user()->id){
            $notification = new Notification;
            $notification->user_id = $commentAuthor;
            $notification->type = 'comment_like';
            $notification->data = json_encode([
                'reason_user_id' => auth()->user()->id,
                'post_id' => $comment->post_id,
            ]);
            $notification->save();
        }

        // Vraťte JSON odpověď s úspěchem
        return response()->json(['success' => 'Komentář byl úspěšně lajkován.']);
    }


    public function unlike($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $like = $comment->likes()->where('user_id', auth()->user()->id)->first();
        $like->delete();

        // Vraťte JSON odpověď místo přesměrování
        return response()->json(['success' => 'Lajk komentáře byl úspěšně zrušen.']);
    }
}