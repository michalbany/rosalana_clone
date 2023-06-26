<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Models\User;

use App\Services\HomeFeedService; // propojení s FeedService
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $homeFeedService; // propojení s FeedService

        // injektujeme službu jako závislost
    public function __construct(HomeFeedService $homeFeedService)
    {
        $this->middleware('auth');
        $this->homeFeedService = $homeFeedService; // propojení s FeedService
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $followController = new FollowController();
        $postController = new PostController();

        $posts = $this->homeFeedService->loadMorePosts(auth()->id(), 'feeds');
        $followingPosts = $this->homeFeedService->loadMorePosts(auth()->id(), 'following');

        // Získej uživatele k následování
        $usersToFollow = $followController->getUsersToFollow();

        // Získej všechny uživatele
        $users = User::select('id', 'name', 'username', 'profile_image')->get();

        // Získej nejlepší příspěvky
        $topPosts = $postController->getTopPosts();

        // Předat proměnné do pohledu
        return view('home', compact('posts', 'followingPosts', 'usersToFollow', 'users', 'topPosts'));
    }


    public function loadMorePosts(Request $request)
    {

        $userId = auth()->id();
        $feedType = $request->input('feedType');
        $lastPostId = $request->input('lastPostId');
        $limit = $request->input('limit', 5);

        $posts = $this->homeFeedService->loadMorePosts($userId, $feedType, $lastPostId, $limit);

        $output = '';

        foreach($posts as $post) {
            $output .= view('partials.post', compact('post'))->render();
        }
        
        return response($output);
    }

}
