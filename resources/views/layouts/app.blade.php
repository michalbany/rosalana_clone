<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="search-url" content="{{ route('search') }}">
        <meta name="notifications-url" content="{{ route('notifications.json') }}">
        @yield('meta')
        <title>@yield('title')</title>
        <link rel="icon" href="{{ asset('images/icon.png') }}" sizes="128x128" type="image/png">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <!-- Quill editor pro editaci prispevku jako ve wordu -->
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" charset="utf-8"></script>
        <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
    </head>
    <body>
        <!--FIXME: je to udělany uplně blbe na css -->
        <header>
        <div class="logo">
            <img class="animate__animated animate__rotateIn" src="{{ asset('images/icon.png') }}" alt="Logo">
            <h1>Rosalana</h1>
        </div>

            
        <div class="center-collum">

            <div class="input-text icon">
                <input type="text" id="search-input" placeholder="Hledat...">
                <a class="input-icon"><i class="fas fa-search"></i></a>
                <div id="search-results" class="search-results animate__animated animate__fadeIn" style="display:none;">
                </div>
                <div class="spinner" style="display: none;"></div>
            </div>
            
            <div class="profile">

                <div class="text-vertical">
                    
                    <a class="a text-primary" href="{{ route('profile.show', ['id' => Auth::id()]) }}">Vítej, {{ strtok(Auth::user()->name, ' ') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                        <a class="a text-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Odhlásit se</a>
                    </form>
                </div>
                <div class="photo" style="background-image: url('/profile_images/{{ Auth::user()->profile_image }}');"></div>
            </div>
            
        </div>

        <div class="right-collum">
            <button class="button-icon-secondary dark-mode" id="dark-mode"><i class="fa-solid fa-moon"></i></button>
            <button class="button-icon-secondary notification"><i class="animate__animated animate__swing fa-solid fa-bell"></i><div class="animate__animated animate__rubberBand dot"></div></button>
            <!-- CHANGE: active to ID -->
            <button class="button-icon-primary create-post"><i class="fa-solid fa-feather"></i></button>
            

            <div class="notification-dropdown" style="display: none;">
                
                <h4>Oznámení</h4>
                <div class="notification-list">
                </div>
            </div>

        </div> 
</header>



        <main>

            <!-- NOTE: modal write -->
            <div id=postModal class="modal" style="display: none;">
                <div class="modal_post_content">
                    <span class="close_post">&times;</span>
                    
                    <div class="modal_post_header">

                            <div class="user-name">

                                <div class="photo" style="background-image: url('/profile_images/{{ Auth::user()->profile_image }}');"></div>
                                <div class="text">
                                    <h3>{{ Auth::user()->name }}</h3>
                                    <p>{!! '@' .Auth::user()->username !!}</p>
                                </div>
                                
                            </div>

                            <div class="write-share-settings">

                                <div class="share-type">
                                    
                                    <button type="button" class="button-dropdown" id="share-type"><i class="fa-solid fa-earth-africa"></i>Veřejně<i class="dart fa-solid fa-chevron-down"></i></button>
                                    
                                    <div class="share-dropdown" style="display: none;">
                                        <a id="public"><i class="fa-solid fa-earth-africa"></i>Veřejně</a>
                                        <a id="friends"><i class="fa-solid fa-user-friends"></i>Přátelé</a>
                                        <a id="private"><i class="fa-solid fa-lock"></i>Soukromě</a>
                                    </div>
                                </div>

                                <div class="collection-type">
                                    <i class="feature-locked fa-solid fa-lock"></i>
                                <button type="button" class="button-dropdown" id="collection-type">Vybrat sbírku<i class="dart fa-solid fa-chevron-down"></i></button>
                                    <div class="collection-dropdown" style="display: none;">
                                        <div class="checkbox">
                                            <input type="checkbox" name="collection" id="collection" style="display: none;">
                                            <label for="collection" class="checkbox-label">
                                                <svg width="14px" height="14px" viewBox="0 0 18 18">
                                                    <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                                    <polyline points="1 9 7 14 15 4"></polyline>
                                                </svg>
                                            </label>
                                            <p class="checkbox-text" id="checkboxText">Sbírka 1</p>
                                        </div>

                                        <div class="checkbox">
                                            <input type="checkbox" name="collectiontwo" id="collectiontwo" style="display: none;">
                                            <label for="collectiontwo" class="checkbox-label">
                                                <svg width="14px" height="14px" viewBox="0 0 18 18">
                                                    <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                                                    <polyline points="1 9 7 14 15 4"></polyline>
                                                </svg>
                                            </label>
                                            <p class="checkbox-text" id="checkboxText">Sbírka 2</p>

                                        </div>

                                        <button class="button-dropdown" id="collection-add"><i class="fa-solid fa-plus"></i>Nová</button>
                                            
                                            

                                    </div>
                                </div>
                                
                            </div>        
                    </div>
                    <form class="write" action="{{ route('posts.store') }}" method="POST">
                        @csrf


                        <div class="form-group"> 
                            <!-- IDEA: nastavit na form-group scroll atd. -->
                            <input type="text" class="form-control" id="title" name="title" placeholder="Nadpis" maxlength="65" required>
                        
                            <textarea class="form-control" id="description" name="description" placeholder="Popis" maxlength="300"></textarea>
                        
                            <!-- Quill editor -->
                            <div id="quill-editor" placeholder="heelo"></div>

                            <input type="hidden" id="shareTypeInput" name="share_type" value="public">

                        </div>

                        <div class="write-botton">
                            <button type="submit" class="button-action">
                                <span class="button-content">Poslat do světa</span>
                                <div class="arrow-wrapper">
                                    <div class="arrow"></div>
                                </div>
                            </button>

                            <div class="price-set">
                            <i class="feature-locked fa-solid fa-lock"></i>
                                
                                <p class="free-text">Zdarma</p>

                                <label id="price-switch" class="switch">
                                    <input type="checkbox">
                                    <span class="switcher"></span>
                                </label>
                                <p class="price-text">Cena:</p>
                                <input type="number" id="price" name="price" min="0" max="999" value="" step="5" disabled>
                                <p class="currency">Kč</p>
                            </div>

                                
                        </div>
                    </form>
                </div>
            </div>


            <!-- NOTE: modal rank -->
            <div id=rankModal class="modal" style="{{ auth()->user()->shouldShowRankModal() ? 'display: block;' : 'display: none;' }}">
                <div class="modal_rank_content animate__animated animate__bounceIn">
                    <span class="close_rank die_rank">&times;</span>
                    
                    <div class="rank-content">
                        <img class="rank-cup" src="{{ asset('images/' . auth()->user()->rankModalContent['imgSrc']) }}" alt="Cup">
                        <h2>{{ auth()->user()->rank }}!</h2>
                        <p>Gratulujeme, právě jsi postoupil na novou úroveň.</p>
                        <div class="unlocked">
                            <p>Odemčené funkce:</p>
                            <ul>
                            @foreach(auth()->user()->rankModalContent['features'] as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                            </ul>
                        </div>
                        <button class="button-secondary die_rank">Pokračovat</button>
                    </div>
                </div>
            </div>







            <div class="left">
            <div class="top"></div>
                <h4>Menu</h4>
                <nav>
                <div class="menu">
                            
                            <div class="item @yield('home')"><a class="a text-menu" href="/home"><i class="fa-solid fa-house"></i>Hlavní strana</a></div>
                            <div class="item @yield('profile')"><a class="a text-menu" href="{{ route('profile.show', ['id' => Auth::id()]) }}"><i class="fa-solid fa-user"></i>Profil</a></div>
                            <div class="item disabled"><a class="a text-menu" href="#"><i class="fa-solid fa-triangle-exclamation"></i></i>Objevuj</a></div>
                            <!-- ADD: @yield('explore')  -->
                            <div class="item disabled"><a class="a text-menu" href="#"><i class="fa-solid fa-triangle-exclamation"></i></i>Výzvy</a></div>
                            <!-- ADD: @yield('challenge') -->
                            <div class="item disabled"><a class="a text-menu" href="#"><i class="fa-solid fa-triangle-exclamation"></i></i>Nastavení</a></div>
                            <!-- ADD: @yield('settings') -->
                        </div>
                </nav>

                <h4>Skupiny</h4>

                <div class="alert-banner w">
                    <h5><i class="fa-solid fa-triangle-exclamation"></i> Upozornění!</h5>
                    <p>Skupiny jsou zatím ve vývoji a budou přidány brzy.</p>
                </div>

                <div class="alert-banner">
                    <h5><i class="fa-solid fa-triangle-exclamation"></i> Upozornění!</h5>
                    <p>Jste součástí testování. Nekteré funkce nemusí být dostupně nebo nemusí fungovat správně.</p>
                </div>
            </div>
            <div class="main">@yield('content')</div>
            <div class="right">
                
            <div class="top"></div>
                <div class="right-content">

                    <div class="right-content-box">
                        <h4>Doporučení uživatelé</h4>
                        @foreach($usersToFollow as $userToFollow)
                        <div class="user-banner">
                            
                            <div class="user">
                                
                                <div class="photo" style="background-image: url('/profile_images/{{ $userToFollow->profile_image }}');"></div>
                                <div class="text-vertical">
                                    <a class="a text-secondary-link" href="{{ route('profile.show', ['id' => $userToFollow->id]) }}">{{ $userToFollow->name }}</a>
                                    <p>{!! '@' .$userToFollow->username !!}</p>
                                </div>
                            </div>
                            
                            @if(Auth::check() && Auth::user()->id !== $userToFollow->id)
                            @if(Auth::user()->following->contains($userToFollow->id))
                            <form action="{{ route('unfollow', $userToFollow->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button-secondary unfollow-btn">Sleduji</button>
                            </form>
                            @else
                            <form action="{{ route('follow', $userToFollow->id) }}" method="POST">
                                @csrf
                                <button class="button-secondary" type="submit">Sledovat</button>
                            </form>
                            @endif
                            @endif
                        </div>
                        @endforeach
                        <div class="horizontal-line"></div>
                    </div>



                    <div class="right-content-box">
                        <h4>Populární příspěvky</h4>
                        @foreach($topPosts as $topPost)
                        <div class="post-banner">
                             <div class="post-view"><!-- CHANGE: na .post po redesign  -->
                                <div class="text-vertical">
                                    <h3>{{ $topPost->title }}</h3>
                                    <p>{{ Str::limit($topPost->description, 100) }}</p>
                                </div>
                                <div class="post-info">
                                    <div class="post-user">
                                        
                                        <div class="photo"  style="background-image: url('/profile_images/{{ $topPost->user->profile_image }}');"></div>
                                        <a class="a text-tertiary" href="{{ route('profile.show', ['id' => $topPost->user->id]) }}">{{ $topPost->user->name }}</a>
                                        
                                    </div>
                                    <div class="post-stats">
                                        <span><i class="icon fa-regular fa-heart"></i> {{ $topPost->likes_count }}</span>
                                        <span><i class="icon fa-solid fa-users"></i> {{ $topPost->views }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        <div class="horizontal-line"></div>
                    </div>

                </div>
            </div>
            
        </main>

    @yield('scripts')
</body>
</html>


