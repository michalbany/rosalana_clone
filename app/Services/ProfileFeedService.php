<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class ProfileFeedService{

    /**
    * Postupné načítání příspěvků
    *
    */
    public function loadMorePosts($userId, $viewerId, $feedType, $lastPostId = null, $limit = 5)
    {

        if ($feedType === 'own') {
            return $this->userOwn($userId, $viewerId, $lastPostId, $limit);
        } else if ($feedType === 'favourite') {
            return $this->userFavourite($userId, $viewerId, $lastPostId, $limit);
        } else if ($feedType === 'privated') {
            return $this->userPrivate($userId, $lastPostId, $limit);
        }
    
        return null;
    }
    
    /**
    * Metody filtrování příspěvků
    *
    */
    public function userOwn($userId, $viewerId, $lastPostId = null, $limit = 5)
    {
        $user = User::find($userId);

        $query = $user->posts()->visibleTo($viewerId)->orderBy('created_at', 'desc');
    
        if (!is_null($lastPostId)) {
            $query->where('id', '<', $lastPostId);
        }
    
        $posts = $query->withCount('likes')->take($limit)->get();
    
        return $posts;
    }

    public function userFavourite($userId, $viewerId, $lastPostId = null, $limit = 5)
    {
        $user = User::find($userId);


        $likedPostIds = $user->likes->pluck('post_id');

        $query = Post::whereIn('id', $likedPostIds)
                    ->visibleTo($viewerId)
                    ->orderBy('created_at', 'desc');

        if (!is_null($lastPostId)) {
            $query->where('id', '<', $lastPostId);
        }

        $posts = $query->withCount('likes')->take($limit)->get();

        return $posts;
    }

    public function userPrivate($userId, $lastPostId = null, $limit = 5)
    {  
        $user = User::find($userId);

        $query = $user->posts()->where('share_type', 'private')->orderBy('created_at', 'desc');
        
        if (!is_null($lastPostId)) {
            $query->where('id', '<', $lastPostId);
        }

        $posts = $query->withCount('likes')->take($limit)->get();

        return $posts;
    }

    
}