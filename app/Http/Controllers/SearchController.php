<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $userId = auth()->id();

        $users = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('username', 'like', '%' . $search . '%')
            ->get(['id', 'name']);

        $posts = Post::visibleTo($userId)
            ->where('title', 'like', '%' . $search . '%')
            ->get(['id', 'title']);

        return response()->json([
            'users' => $users,
            'posts' => $posts
        ]);
    }
}