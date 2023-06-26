<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Notification;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        $follower = auth()->user();
        if (!$follower->following->contains($user->id)) {
            $follower->following()->attach($user->id);


            // Zvýšení bodů pro sledujícího uživatele (1 bod)
            $follower->rank_points += 1;
            $follower->save();

            // Zvýšení bodů pro sledovaného uživatele (2 body)
            $user->rank_points += 2;
            $user->save();

            // Vytvoření notifikace
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->type = 'follow';
            $notification->data = json_encode([
                'reason_user_id' => $follower->id,
            ]);
            $notification->save();

        }
        return back();
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();
        if ($follower->following->contains($user->id)) {
            $follower->following()->detach($user->id);


            // Snížení bodů pro sledujícího uživatele (1 bod)
            $follower->rank_points -= 1;
            $follower->save();

            // Snížení bodů pro sledovaného uživatele (2 body)
            $user->rank_points -= 2;
            $user->save();
                
        }
        return back();
    }

    public function getUsersToFollow()
    {
        $user = auth()->user();
        $users = User::where('id', '<>', $user->id)
                    ->select('id', 'name', 'username', 'profile_image')
                    ->get();

        // REMOVE: ukazuje i uživatele, které už sleduješ
        // $usersToFollow = $users->merge($user->following);
        $usersToFollow = $users->diff($user->following);
        return $usersToFollow->take(5);
    }

}

