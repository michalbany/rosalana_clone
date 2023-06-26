<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail; // must verify email
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_image',
        'cover_image',
        'bio',
        'rank_points',
        'rank_modal_shown',
        'last_rank_shown',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Metody pro přidávání příspěvků
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Metody pro follow/unfollow
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function getRankAttribute()
    {
        $points = $this->rank_points;

        if ($points < 100) {
            return 'Začátečník';
        } elseif ($points < 500) {
            return 'Nadějný autor';
        } elseif ($points < 2000) {
            return 'Talentovaný autor';
        } elseif ($points < 5000) {
            return 'Mistr slova';
        } elseif ($points < 10000) {
            return 'Partner';
        } elseif ($points < 20000) {
            return 'Autor bestsellerů';
        } else {
            return 'Literární velikán';
        }
    }
    //funkce pro zobrazení progress baru
    public function getRankProgressAttribute()
    {   
        $points = $this->rank_points;
        $previousRankMinPoints = 0;
        $currentRankMaxPoints = 100;

        if ($points < 100) {
            $currentRankMaxPoints = 100;
            $previousRankMinPoints = 0;
        } elseif ($points < 500) {
            $currentRankMaxPoints = 500;
            $previousRankMinPoints = 100;
        } elseif ($points < 2000) {
            $currentRankMaxPoints = 2000;
            $previousRankMinPoints = 500;
        } elseif ($points < 5000) {
            $currentRankMaxPoints = 5000;
            $previousRankMinPoints = 2000;
        } elseif ($points < 10000) {
            $currentRankMaxPoints = 10000;
            $previousRankMinPoints = 5000;
        } elseif ($points < 20000) {
            $currentRankMaxPoints = 20000;
            $previousRankMinPoints = 10000;
        } else {
            $previousRankMinPoints = 20000;
            $currentRankMaxPoints = $points;
        }

        $totalPointsInRank = $currentRankMaxPoints - $previousRankMinPoints;
        $userPointsInRank = $points - $previousRankMinPoints;

        return ['max' => $totalPointsInRank, 'current' => $userPointsInRank];
    }


    public function shouldShowRankModal()
    {
        $rank = $this->getRankAttribute();
        if ($this->last_rank_shown != $rank){
            $this->last_rank_shown = $rank;
            $this->rank_modal_shown = true;
            $this->save();
        }
        return $this->rank_modal_shown;
    }


    public function closeRankModal()
    {
        $this->rank_modal_shown = false;
        $this->save();
    }

    

    public function getRankModalContentAttribute()
    {
        $rank = $this->getRankAttribute();
        $imgScr = '';
        $features = [];

        switch ($rank) {
            case "Začátečník":
                $imgSrc = '01-zacatecnik.svg';
                $features = ["Publikování příspěvků",
                            "Komentování příspěvků",
                            "Likování příspěvků", 
                            "Sledování uživatelů"
                        ];
                break;
            case "Nadějný autor":
                $imgSrc = '02-nadejny_autor.svg';
                $features = ["Vytváření vlastních sbírek", 
                            "Mesíční výzvy", 
                            "Odznaky u jména", 
                            "Přídání odkazu na profil"
                        ];
                break;
            case "Talentovaný autor":
                $imgSrc = '03-talentovany_autor.svg';
                $features = ["Jeden placený příspěvek měsíčně", 
                            "Zvýhodněné zobrazení a doporučení", 
                            "Pokročilé úpravy profilu", 
                            "Funkce 4"
                        ];
                break;
            case "Mistr slova":
                $imgSrc = '04-mistr_slova.svg';
                $features = ["Tři placené příspěvky měsíčně", 
                            "Vytváření vlastních skupin", 
                            "Vytváření výzvy pro ostatní", 
                            "Funkce 8"
                        ];
                break;
            case "Partner":
                $imgSrc = '05-partner.svg';
                $features = ["Neomezený počet placených příspěvků", 
                            "Sleva na placené služby u ostatních", 
                            "Imunita vůči ztrátě RANKU", 
                            "Vytváření soukromých skupin"
                        ];
                break;
            case "Autor bestsellerů":
                $imgSrc = '06-autor_bestselleru.svg';
                $features = ["Zvýšený podíl z placených příspěvků", 
                            "Možnost organizovat vlastní akce a workshopy jménem platformy", 
                            "Funkce měsíčního předplatného", 
                            "Funkce 8"
                        ];
                break;
            case "Literární velikán":
                $imgSrc = '07-literarni_velikan.svg';
                $features = ["Vydání vlastní knihy pod záštitou platformy", 
                            "Prémiový zákaznický servis a podpora", 
                            "Funkce 7", 
                            "Funkce 8"
                        ];
                break;
        }

        $modalContent = [
            'rank' => $rank,
            'imgSrc' => $imgSrc,
            'features' => $features
        ];

        return $modalContent;
    }
}
