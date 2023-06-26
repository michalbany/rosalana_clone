<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class HomeFeedService{

    /**
    * Postupné načítání příspěvků
    *
    */
    public function loadMorePosts($userId, $feedType, $lastPostId = null, $limit = 5)
    {
        if ($feedType === 'feeds') {
             return $this->homeFeed($userId, $lastPostId, $limit);
        } else if ($feedType === 'following') {
            return $this->homeFollow($userId, $lastPostId, $limit);
        }
    
        return null;
    }


    /**
    * Metody filtrování příspěvků
    *
    */
    public function homeFeed($userId, $lastPostId = null, $limit = 5)
    {
        $query = Post::visibleTo($userId)->orderBy('created_at', 'desc');

        if (!is_null($lastPostId)) {
            $query->where('id', '<', $lastPostId);
        }

        $posts = $query->withCount('likes')->take($limit)->get();

        return $posts;
    }

    public function homeFollow($userId, $lastPostId = null, $limit = 5)
    {
        $user = User::find($userId);
        $followingIds = $user->following()->pluck('users.id')->toArray();
        $followingIds[] = $userId;

        $query = Post::whereIn('user_id', $followingIds)
            ->visibleTo($userId)
            ->orderBy('created_at', 'desc');

        if (!is_null($lastPostId)) {
            $query->where('id', '<', $lastPostId);
        }

        $followingPosts = $query->withCount('likes')->take($limit)->get();

        return $followingPosts;
    }

}
