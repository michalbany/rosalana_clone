@extends('layouts.app')

@section('title', 'Hlavní strana | Rosalana')

@section('home', 'picked')

@section('content')

<div class="top"></div><!--NOTE: margin top-->

<!-- <div class="welcome-banner">

    <div class="text">
        <h2>Vítej v Rosalana</h2>
        <p>Užij si svůj kousek ráje</p>
    </div>
    
    <button class="button-secondary create-post">Napiš příspěvek<i class="fa-solid fa-feather"></i></button>
</div> -->

<div class="actuality-banner">
    <div class="header-text">
        <h4>Aktuální dění</h4>
        <div class="header-swap">
            <a class="a text-tertiary active" data-target="challenge">Výzvy</a>
            <a class="a text-tertiary" data-target="news">Novinky</a>
            <a class="a text-tertiary w" data-target="actuality"><i class="fa-solid fa-triangle-exclamation"></i> Komplikace</a>
        </div>
    </div>
    <!-- <div class="actuality-banner-message">
    <h5><i class="fa-solid fa-triangle-exclamation"></i> Upozornění!</h5>
            <p>Tyto funkce jsou zatím ve vývoji a budou přidány brzy.</p>
    </div> -->
    <div class="actuality-content" id="challenge">

        <div class="challenge-box animate__animated animate__fadeInLeft" style="animation-delay: 0.15s;">
            <div class="challenge-image"><span class="challenge-count">+50 RP</span></div>
            
            <div class="challenge-box-content">
                <div class="challenge-text">
                    <h5>Letní výzva</h5>
                    <p>Získej body a odznak!</p>
                </div>
            
                <div class="challenge-stats">
                    <button class="button-quaternary"><i class="fa-solid fa-right-to-bracket"></i></button>
                </div>
            </div>
                <!-- IDEA: omezený počet uživatelů na výzvě například 0/20 -->
                <!-- <span>+50 RP</span> -->
        </div>

        <div class="challenge-box animate__animated animate__fadeInLeft" style="animation-delay: 0.1s;">
            <div class="challenge-image" style="background-color: var(--orange);"><span class="challenge-count">+50 RP</span></div>    
            
            <div class="challenge-box-content">
                <div class="challenge-text">
                    <h5>Letní výzva</h5>
                    <p>Získej body a odznak!</p>
                </div>
            
                <div class="challenge-stats">
                    <button class="button-quaternary"><i class="fa-solid fa-right-to-bracket"></i></button>
                </div>
            </div>
                <!-- IDEA: omezený počet uživatelů na výzvě například 0/20 -->
                <!-- <span>+50 RP</span> -->
        </div>

        <div class="challenge-box animate__animated animate__fadeInLeft" style="animation-delay: 0.05s;">
            <div class="challenge-image"><span class="challenge-count">+50 RP</span></div>

            <div class="challenge-box-content">
                <div class="challenge-text">
                    <h5>Letní výzva</h5>
                    <p>Získej body a odznak!</p>
                </div>
            
                <div class="challenge-stats">
                    <button class="button-quaternary"><i class="fa-solid fa-right-to-bracket"></i></button>
                </div>
            </div>
                <!-- IDEA: omezený počet uživatelů na výzvě například 0/20 -->
                <!-- <span>+50 RP</span> -->
        </div>
    
    </div>

    <div class="actuality-content" id="news" style="display: none;">
    
        <div class="challenge-box w animate__animated animate__fadeInLeft">
            <h5><i class="fa-solid fa-triangle-exclamation"></i> Upozornění!</h5>
            <p>Novinky jsou zatím ve vývoji a budou přidány brzy.</p>
            <div class="challenge-stats" style="visibility: hidden;">
                <button class="button-quaternary">Zúčastnit se</button>
                <!-- IDEA: omezený počet uživatelů na výzvě například 0/20 -->
                <span>+50 RP</span>
            </div>
        </div>
    
    </div>

    <div class="actuality-content" id="actuality" style="display: none;">
    
        <div class="challenge-box w animate__animated animate__fadeInLeft">
            <h5><i class="fa-solid fa-triangle-exclamation"></i> Velikost obrazovky</h5>
            <p>Víme o problémech zobrazení na zařízeních Mac a obrazovkách s jiným rozlišením než 1920x1080px. Na odstranění problému již pracujeme.</p>
            <p><strong>HOT FIXED:</strong> Zobrazení formuláře pro přidání příspěvků.</p>
            <div class="challenge-stats" style="visibility: hidden;">
                <button class="button-quaternary">Zúčastnit se</button>
                <!-- IDEA: omezený počet uživatelů na výzvě například 0/20 -->
                <span>+50 RP</span>
            </div>
        </div>

        <div class="challenge-box w animate__animated animate__fadeInLeft">
            <h5><i class="fa-solid fa-triangle-exclamation"></i> Mobilní zařízení</h5>
            <p>Aplikace zatím není dostupná na mobilních zařízeních. Tento problém vyřeší další aktualizace.</p>
            <div class="challenge-stats" style="visibility: hidden;">
                <button class="button-quaternary">Zúčastnit se</button>
                <!-- IDEA: omezený počet uživatelů na výzvě například 0/20 -->
                <span>+50 RP</span>
            </div>
        </div>
    
    </div>


</div>


<div class="post-banner">
<div class="post-header-text">
        <h4>Nedávné příspěvky</h4>
        <div class="post-swap">
            <a class="a text-tertiary active" href="#" data-target="feeds">Feeds</a>
            <a class="a text-tertiary" href="#" data-target="following">Sleduji</a>
            <a class="a text-tertiary" href="#" data-target="popular">Žhavé</a>
            <a class="a text-tertiary" href="#" data-target="groups">Skupiny</a>
        </div>
    </div>
    <div class="post-content" id="feeds">
    <!-- NOTE: v prvním to být musí protože 5 se volá bez JS -->
    @foreach($posts as $post)
        @include('partials.post', ['post' => $post])
    @endforeach
    </div>

    <div class="post-content" id="following" style="display: none;">
    
    <!-- FIXME: if postsCount < 5 -> vypíší se 2x -->
    @foreach($followingPosts as $post)
        @include('partials.post', ['post' => $post])
    @endforeach
    </div>

    <div class="post-content" id="popular" style="display: none;">
        <div class="post w animate__animated animate__fadeInLeft">
            <h5><i class="fa-solid fa-triangle-exclamation"></i> Upozornění!</h5>
            <p>Sekce je zatím ve vývoji a bude přidána brzy.</p>

        </div>
    </div>

    <div class="post-content" id="groups" style="display: none;">
        <div class="post w animate__animated animate__fadeInLeft">
            <h5><i class="fa-solid fa-triangle-exclamation"></i> Upozornění!</h5>
            <p>Sekce je zatím ve vývoji a bude přidána brzy.</p>

        </div>
    </div>
</div>


@endsection





<!--CHANGE: toto je správný kod aby mizeli uživatelé, kteří už sledoval.
CHANGE: v souboru FollowController.php v metodě getUserToFollow()

@section('right')
<div class="top"></div>
@foreach($usersToFollow as $userToFollow)
    <div class="user-banner">
        <h3>{{ $userToFollow->name }}</h3>
        <p>{{ $userToFollow->username }}</p>
        <form action="{{ route('follow', $userToFollow->id) }}" method="POST">
            @csrf
            <button type="submit">Follow</button>
        </form>
    </div>
@endforeach
@endsection
-->


<!--TODO: script
    -- text area resize
    -- 
-->

@section('scripts')
<script>
$(document).ready(function(){

    //přepínání mezi záložkami v actuality (výzvy, novinky, aktualizace)

    // Při kliknutí na odkaz v .header-swap
    $(".header-swap a").click(function(e) {
        e.preventDefault(); // Zamezíme výchozí akci odkazu

        // Nastavení aktivního stavu pro položku menu
        $(".header-swap a").removeClass("active");
        $(this).addClass("active");

        // Získáme hodnotu data atributu
        var target = $(this).data("target");

        // Skryjeme všechny sekce
        $(".actuality-content").hide();

        // Zobrazíme tu, která odpovídá kliknutému odkazu
        $("#" + target).show();
    });


    //přepínání mezi záložkami v postech (feeds, following, hot, groups)
    //pri kliknuti na odkaz v .post-swap


    $(".post-swap a").click(function(e) {
        e.preventDefault(); // Zamezíme výchozí akci odkazu

        // Nastavení aktivního stavu pro položku menu
        $(".post-swap a").removeClass("active");
        $(this).addClass("active");

        // Získáme hodnotu data atributu
        var target = $(this).data("target");

        // Odebrání příspěvků z aktuálně aktivní záložky
        $("#" + activeTab).empty();

        lastPostIds[activeTab] = null;
        
        // Aktualizace aktivní záložky
        activeTab = target;

        // Skryjeme všechny sekce
        $(".post-content").hide();

        // Zobrazíme tu, která odpovídá kliknutému odkazu
        $("#" + target).show();

        // Načtení příspěvků pro nově aktivní záložku
        loadMorePosts();
    });





    let activeTab = 'feeds';
    let lastPostIds = {
    'feeds': $("#" + activeTab + " .post:last").data('id'),
    'following': $("#" + activeTab + " .post:last").data('id'),
    };

function loadMorePosts() {
    // Zkontrolujeme, zda jsme na správné záložce
    if (activeTab !== 'feeds' && activeTab !== 'following') {
        return;
    }

    $.ajax({
        url: '/load-more-posts',
        type: 'GET',
        async: false,
        data: {
            lastPostId: lastPostIds[activeTab],
            feedType: activeTab,
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
        loadMorePosts();
    }
});


});
</script>
@endsection