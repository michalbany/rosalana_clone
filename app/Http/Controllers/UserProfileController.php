<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Services\ProfileFeedService; // propojení s FeedService

class UserProfileController extends Controller
{
    
    protected $profileFeedService; // propojení s FeedService

    public function __construct(ProfileFeedService $profileFeedService)
    {
        $this->middleware('auth');
        $this->profileFeedService = $profileFeedService; // propojení s FeedService
    }
    
    
    public function show($id)
    {
        $user = User::find($id);
        $viewerId = auth()->id();

        if ($user) {
            // Získání příspěvků pro každý typ feedu

            $posts = $this->profileFeedService->loadMorePosts($id, $viewerId, 'own');
            $favouritePosts = $this->profileFeedService->loadMorePosts($id, $viewerId, 'favourite');
            $privatePosts = $this->profileFeedService->loadMorePosts($id, $viewerId, 'privated');
              
            
            $followersCount = $user->followers()->count();
            $followingCount = $user->following()->count();


            // Získání uživatelů k následování a nejlepších příspěvků
            $followController = new FollowController();
            $postController = new PostController();
            $usersToFollow = $followController->getUsersToFollow();
            $topPosts = $postController->getTopPosts();

            $view = (Auth::id() === $user->id) ? 'profiles.own_profile' : 'profiles.other_profile';
            return view($view, compact('user', 'posts', 'favouritePosts', 'privatePosts', 'followersCount', 'followingCount', 'usersToFollow', 'topPosts'));
        } else {
            
            return redirect()->route('home')->with('error', 'Uživatel nebyl nalezen.');
        }
    }

    
    public function loadMoreUserPosts(Request $request, $id)
    {

        $viewerId = auth()->id();
        $userId = User::find($id)->id;
        $feedType = $request->input('feedType');
        $lastPostId = $request->input('lastPostId');
        $limit = $request->input('limit', 5);

        $posts = $this->profileFeedService->loadMorePosts($userId, $viewerId, $feedType, $lastPostId, $limit);

        $output = '';

        foreach($posts as $post) {
            $output .= view('partials.post', compact('post'))->render();
        }
        
        return response($output);
    }

    
    
    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);

        // Ověření, zda se jedná o vlastní účet
        if ($user->id != auth()->user()->id) {
            return redirect()->back()->with('error', 'Nemáte oprávnění upravit tento profil.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'bio' => 'nullable|string|max:500',
        ]);
        

        $user->name = $request->input('name');
        $user->username = $request->input('username');

        if ($request->hasFile('profile_image')) {
            // Smazání starého profilového obrázku
            if ($user->profile_image) {
                $oldProfileImage = public_path('profile_images/' . $user->profile_image);
                if (file_exists($oldProfileImage)) {
                    unlink($oldProfileImage);
                }
            }

            $profileImage = $request->file('profile_image');
            $profileImageName = time() . '_' . $profileImage->getClientOriginalName();
            $profileImage->move(public_path('profile_images'), $profileImageName);
            $user->profile_image = $profileImageName;
        }

        if ($request->hasFile('cover_image')) {
            // Smazání starého úvodního obrázku
            if ($user->cover_image) {
                $oldCoverImage = public_path('cover_images/' . $user->cover_image);
                if (file_exists($oldCoverImage)) {
                    unlink($oldCoverImage);
                }
            }

            $coverImage = $request->file('cover_image');
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->move(public_path('cover_images'), $coverImageName);
            $user->cover_image = $coverImageName;
        }

        $user->bio = $request->input('bio');
        $user->save();

        return redirect()->back()->with('success', 'Profil byl úspěšně aktualizován.');
    }

    public function closeRankModal()
    {
        $user = auth()->user();
        $user->closeRankModal();

        return response()->json(['success' => true]);
    }

}

