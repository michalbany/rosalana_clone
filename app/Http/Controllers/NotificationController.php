<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotificationsJson()
    {
        $user = Auth::user();

        $notifications = Notification::where('user_id', $user->id)
                        // ->whereNull('read_at') zobrazovat pouze nepřečtené notifikace
                        ->orderBy('created_at', 'desc')
                        ->take(50)
                        ->get();
                        

        // připravíme notifikace pro zobrazení ve frontendu
        $preparedNotifications = [];
        foreach ($notifications as $notification) {

            $data = json_decode($notification->data, true);

            $reasonUser = User::find($data['reason_user_id']);
            $notification_photo = $reasonUser->profile_image;
            
            switch($notification->type) {
                case 'like':
                    $message = 'Uživateli <strong>' . $reasonUser->name . '</strong> se líbí váš příspěvek <strong>' . Post::find($data['post_id'])->title . '</strong>.';
                    $location = '/post/' . $data['post_id'];
                    break;
                case 'follow':
                    $message = 'Uživatel <strong>' . $reasonUser->name . '</strong> vás začal sledovat.';
                    $location = '/user/' . $data['reason_user_id'];
                    break;
                case 'comment':
                    $message = 'Uživatel <strong>' . $reasonUser->name . '</strong> okomentoval váš příspěvek <strong>' . Post::find($data['post_id'])->title . '</strong>.';
                    $location = '/post/' . $data['post_id'];
                    break;
                case 'comment_like':
                    $message = 'Uživateli <strong>' . $reasonUser->name . '</strong> se líbí váš komentář.';
                    $location = '/post/' . $data['post_id'];
                    break;
                // další typy notifikací...
            }

            $time = $notification->created_at->diffForHumans();

            $time = str_replace('před', '', $time);
            $time = str_replace('sekundami', 'sec', $time);
            $time = str_replace('sekundou', 'sec', $time);
            $time = str_replace('minutami', 'min', $time);
            $time = str_replace('minutou', 'min', $time);
            $time = str_replace('hodinami', 'hod', $time);
            $time = str_replace('hodinou', 'hod', $time);


            $preparedNotifications[] = [
                'id' => $notification->id,
                'message' => $message,
                'read_at' => $notification->read_at,
                'created_at' => trim($time),
                'location' => $location ?? null,
                'read' => $notification->read_at ? true : false,
                'notification_photo' => $notification_photo ?? null
            ];
        }

        return response()->json(['notifications' => $preparedNotifications]);
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification && $notification->user_id == Auth::user()->id) {
            $notification->read_at = now();
            $notification->save();
        }

        return back();
    }
}
