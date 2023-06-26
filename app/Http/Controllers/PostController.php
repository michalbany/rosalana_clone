<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use HTMLPurifier;
use HTMLPurifier_Config;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /*NOTE: 
    metoda create neni potřeba protože vytváříme příspěvek přímo na hlavní 
    stránce a neodkazujeme se na žádnou jinou stránku

     * Show the form for creating a new resource.
     * 
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'share_type' => 'required|in:public,friends,private',
        ]);

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($request->content);

        $post = new Post([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'content' => $clean_html,
            'share_type' => $request->share_type,
        ]);

        $post->save();

        // Zvýšení bodů autora
        $user = auth()->user();
        $user->rank_points += 5;
        $user->save();

        return redirect()->route('home')->with('success', 'Příspěvek byl úspěšně vytvořen.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('user', 'comments.user')->findOrFail($id);
        $isOwnPost = auth()->check() && auth()->user()->id === $post->user_id;
        
        // Získání uživatelů k následování a nejlepších příspěvků
        $followController = new FollowController();
        $postController = new PostController();
        $usersToFollow = $followController->getUsersToFollow();
        $topPosts = $postController->getTopPosts();

        // Zvýšení bodů uživatelů za zhlédnutí příspěvku
        if (!$isOwnPost && auth()->check()) {
            // Získání uživatele, který zhlédne cizí příspěvek
            $viewer = auth()->user();
            $viewer->rank_points += 1;
            $viewer->save();
    
            // Získání autora příspěvku
            $postAuthor = $post->user;
            $postAuthor->rank_points += 1;
            $postAuthor->save();
        }

        if ($isOwnPost) {
            return view('posts.own_post', compact('post', 'usersToFollow', 'topPosts'));
        } else {
            return view('posts.other_post', compact('post', 'usersToFollow', 'topPosts'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getTopPosts()
    {
        return Post::withCount(['likes'])
            ->orderBy('likes_count', 'desc')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();
    }

}
