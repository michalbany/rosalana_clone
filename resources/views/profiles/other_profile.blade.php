@extends('layouts.app')

@section('title', $user->name . ' | Rosalana')

@section('page_icon')
<i class="fa-solid fa-user"></i>
@endsection

@section('page_title', 'Profil')

@section('content')

<div class="top"></div><!--NOTE: margin top-->


<div class="profileHeader">

    <div class="bgphoto" style="background-image: {{ $user->cover_image ? "url('/cover_images/" . $user->cover_image . "')" : "linear-gradient(to right, #645bff, #cf43d2, #fb44a3, #ff647c, #ff8966)" }};"></div>
    <div class="profile_gradient"></div>
    <div class="profilephoto" style="background-image: url('/profile_images/{{ $user->profile_image }}');"></div>



    <div class="header">
                    
        <div class="name">
            <h2>{{ $user->name }}</h2>
            <p>{!!'@' .$user->username !!}</p>
        </div>

        @if(Auth::user() && Auth::user()->id !== $user->id)
        @if(Auth::user()->following->contains($user->id))
        <form action="{{ route('unfollow', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="button-secondary unfollow-btn">Sleduji</button>
        </form>
        @else
        <form action="{{ route('follow', $user->id) }}" method="POST">
            @csrf
            <button type="submit" class="button-secondary">Sledovat</button>
        </form>
        @endif
    @endif
    </div>

    <div class="stats">

        <div class="statsCol">
            <div class="stat">
                <span>{{ $followersCount }}</span>
                <a id="listOfFollowers" href="#">
                    <p>Sledujících</p>
                </a>
            </div>
            <div class="stat">
                <span>{{ $followingCount }}</span>
                <a id="listOfFollows" href="#">
                    <p>Sledovaní</p>
                </a>
            </div>
        </div>

        <div class="rankCol">
            <div class="stat">
                <p><i class="fa-solid fa-ranking-star"></i>Rank</p>
                <div class="graph">
                        <div class="progress" style="width: {{ ($user->rankProgress['current'] / $user->rankProgress['max']) * 100 }}%;"></div>
                    </div>
                <span>{{ $user->rank_points }} - {{ $user->rank }}</span>
            </div>
        </div>
        
    </div>

    
    <div class="user-menu">
        <div class="slider animate__animated animate__fadeInRight"></div>
    <ul class="menu-list">
        <li class="menu-item active"><a href="#" data-target="bio">Bio</a></li>
        <li class="menu-item"><a href="#" data-target="groups">Skupiny</a></li>
        <li class="menu-item"><a href="#" data-target="events">Události</a></li>
        <li class="menu-item"><a href="#" data-target="achievements">Uspěchy</a></li>
        <li class="menu-item"><a href="#" data-target="more">Více</a></li>
    </ul>
    </div>
    <div class="user-content">
    <div class="content-section animate__animated animate__fadeIn" id="bio">
        <h3>O mně:</h3>
                    <p>{{ $user->bio }}</p>
                </div>
    <div class="content-section animate__animated animate__fadeIn" id="groups" style="display: none;">
    <h3>Skupiny:</h3>
    <div class="text">
                    <p>Není zaznámenáváno</p>
                </div>
    </div>
    <div class="content-section animate__animated animate__fadeIn" id="events" style="display: none;">
    <h3>Události:</h3>
    <div class="text">
                    <p>Není zaznámenáváno</p>
                </div>
    </div>
    <div class="content-section animate__animated animate__fadeIn" id="achievements" style="display: none;">
    <h3>Úspěchy:</h3>
    <div class="text">
                    <p>Není zaznámenáváno</p>
                </div>
    </div>
    <div class="content-section animate__animated animate__fadeIn" id="more" style="display: none;">
    <h3>Více:</h3>
    <div class="text">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Přidal se:</strong> {{ $user->created_at->format('d.m.Y') }}</p>
    </div>
                </div>
    </div>

    </div>



<div class="post-banner">
<div class="post-header-text profile">
        <h4>Nedávné příspěvky</h4>
        <div class="post-swap">
            <a class="a text-tertiary active" href="#" data-target="own">Moje příspěvky</a>
            <a class="a text-tertiary" href="#" data-target="favourite">Oblíbené</a>
            <a class="a text-tertiary" href="#" data-target="groupsFeed">Skupiny</a>
        </div>
    </div>
    <div class="post-content" id="own">
    @foreach($posts as $post)
        @include('partials.post', ['post' => $post])
    @endforeach
    </div>

    <div class="post-content" id="favourite" style="display: none;">
    @foreach($favouritePosts as $post)
        @include('partials.post', ['post' => $post])
    @endforeach
    </div>

    <div class="post-content" id="groupsFeed" style="display: none;">
        <div class="post w animate__animated animate__fadeInLeft">
            <h5><i class="fa-solid fa-triangle-exclamation"></i> Upozornění!</h5>
            <p>Sekce je zatím ve vývoji a bude přidána brzy.</p>
        </div>
    </div>

</div>

@endsection







@section('scripts')
<script>
    $(document).ready(function(){

        // Skryjeme všechny sekce obsahu kromě první (Bio)
    // $(".content-section:not(:first)").hide();

    $(".menu-item a").on("click", function(e) {
        e.preventDefault();

        // Nastavení aktivního stavu pro položku menu
        $(".menu-item").removeClass("active");
        $(this).parent().addClass("active");

        // Zjistíme, na kterou sekci se máme přesunout
        var target = $(this).data("target");

        // Skryjeme všechny sekce obsahu
        $(".content-section").hide();

        // Zobrazíme cílovou sekci
        $("#" + target).show();

        // Animace slideru
        var slider = $(".slider");
        var menuItem = $(this).parent();
        var itemPosition = menuItem.position().left;
        var itemWidth = menuItem.outerWidth();
        slider.css({
            left: itemPosition,
            width: itemWidth
        });
    });

    var firstMenuItem = $(".menu-item:first");
    firstMenuItem.addClass("active");
    var itemPosition = firstMenuItem.position().left;
    var itemWidth = firstMenuItem.outerWidth();
    $(".slider").css({
        left: itemPosition,
        width: itemWidth
    });


    var firstMenuItem = $(".menu-item:first");
    firstMenuItem.addClass("active");
    var itemPosition = firstMenuItem.position().left;
    var itemWidth = firstMenuItem.outerWidth();
    $(".slider").css({
        left: itemPosition,
        width: itemWidth
    });

//nacitani prispevku

// Zobrazení příspěvků podle typu

$('.post-swap a').click(function(e) {
        e.preventDefault();

        // Nastavení aktivního stavu pro položku menu
        $(".post-swap a").removeClass("active");
        $(this).addClass('active');

        // Získáme hodnotu data atributu
        var target = $(this).data("target");

        // Aktualizace aktivní záložky
        activeTab = target;

        // Skryjeme všechny sekce
        $(".post-content").hide();

        // Zobrazíme tu, která odpovídá kliknutému odkazu
        $("#" + target).show();
    });

    let activeTab = 'own';
    let lastPostIds = {
        'own': $("#own .post:last").data('id'),
        'favourite': $("#favourite .post:last").data('id'),
    };
    let user_id = {{ $user->id }};

    //nacitaci prispevku
function loadMoreUserPosts() {
    // Zkontrolujeme, zda jsme na správné záložce
    if(activeTab !== 'own' && activeTab !== 'favourite') {
        return;
    }

        $.ajax({
            url: `/users/${user_id}/load-more-posts`,
            type: 'GET',
            async: false,
        data: {
            feedType: activeTab,
            lastPostId: lastPostIds[activeTab],
            
        },
        success: function (data) {
            if (data.trim() == '') {
                console.log('No more posts to load');
            } else {
                $("#" + activeTab).append(data);
                lastPostIds[activeTab] = $("#" + activeTab + " .post:last").data('id');
            }
        },
        error: function () {
            console.log('Error loading more posts');
        }
    });
}

    $(window).on('scroll', function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            loadMoreUserPosts();
        }
    });







    // Otevření edit profile modal
   
    $(window).on("click", function(event) {
        if (event.target == $("#editProfileModal")[0]) {
            $("#editProfileModal").fadeOut();
        }
    });

    $(".header .editBtn").on("click", function(){
        $("#editProfileModal").fadeIn();
    });

    $(".close").on("click", function(){
        $("#editProfileModal").fadeOut();
    });
    

});
</script>
@endsection