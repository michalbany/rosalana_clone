<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'content', 'views', 'share_type'];

    protected $attributes = [
        'share_type' => 'public',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

     /**
     * Scope, který řeší jestli je příspěvek viditelný pro daného uživatele
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisibleTo($query, $userId)
    {
        return $query->where(function ($query) use ($userId) {
            // The user can always see their own posts
            $query->where('user_id', $userId);

            // The user can see 'public' posts by anyone
            $query->orWhere('share_type', 'public');

            // The user can see 'friends' posts by users they are followed by
            $query->orWhere(function ($query) use ($userId) {
                $query->where('share_type', 'friends')
                    ->whereIn('user_id', function ($query) use ($userId) {
                        $query->select('user_id')
                            ->from('followers')
                            ->where('follower_id', $userId)
                            ->whereIn('user_id', function ($query) use ($userId) {
                                $query->select('follower_id')
                                    ->from('followers')
                                    ->where('user_id', $userId);
                            });
                    });
            });
        });
    }

}
