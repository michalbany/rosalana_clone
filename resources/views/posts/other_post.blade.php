@extends('layouts.app')

@section('title', $post->title . ' | Rosalana')

@section('page_icon')
<i class="fa-solid fa-feather"></i>
@endsection

@section('page_title', 'Příspěvek')

@section('content')

<div class="top"></div><!--NOTE: margin top-->

<div class="header">
            <div class="photo"  style="background-image: url('/profile_images/{{ $post->user->profile_image }}');"></div>
                <div class="text">
                    <a class="a text-primary" href="{{ route('profile.show', ['id' => $post->user->id]) }}"><h3 class="a text-menu">{{ $post->user->name }}</h3></a>
                    <p>Přidáno: {{ $post->created_at->setTimeZone('Europe/Prague')->format('d. m. Y H:i') }}</p>
                </div>
            </div>


    <div class="postPageContent">
        
        <h3 class="title">{{ $post->title }}</h3>
        <p class="description">{{ $post->description }}</p>
        <p class="content">{!! $post->content !!}</p>
    </div>


<div class="social">

        <div class="view">
            <button><i class="fa-solid fa-users"></i></button>
            <span>{{ $post->views}}</span>
        </div>
        
        <div class="share">
            <button class="sharePost"><i class="fa-solid fa-share"></i></button>
        </div>

        <div class="like">
    <span>{{ $post->likes->count() }}</span>
    @if(Auth::check())
        @if(Auth::user()->likes->contains('post_id', $post->id))
        <form data-action="{{ route('post.unlike', $post->id) }}" data-method="DELETE">
            @csrf
            @method('DELETE')
            <button type="submit" data-liked="true" class="liked"><i class="fa-solid fa-heart"></i></button>
        </form>
        @else
        <form data-action="{{ route('post.like', $post->id) }}" data-method="POST">
            @csrf
            <button type="submit" data-liked="false"><i class="fa-solid fa-heart"></i></button>
        </form>
        @endif
    @endif
</div>



</div>

<!-- Formulář pro přidání komentáře -->
<div class="comments">
<h3><i class="fa-solid fa-comment"></i>Komentáře</h3>
<form id="add-comment-form" data-post-id="{{ $post->id }}" method="POST">
        @csrf
        <div class="commentCol">
            <textarea name="body" id="body" class="form-control" placeholder="Přidat komentář" rows="3" maxlength="500" required></textarea>
            <button type="submit" class="button-secondary">Přidat</button>
        </div>
    </form>

<!-- Zobrazení komentářů-->
    @if(count($post->comments) > 0)
    <ul class="comments-list">
            @foreach($post->comments->sortByDesc('created_at') as $comment)
                <li>
                    <div class="header">

                        <div class="photo"  style="background-image: url('/profile_images/{{ $comment->user->profile_image }}');"></div>
                        <div class="text">
                        <a class="a text-primary" href="{{ route('profile.show', $comment->user->id) }}"><h4 class="a text-tertiary">{{ $comment->user->name }}</h4></a>
                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>

                        <div class="like">
                    <span id="likes-count-{{ $comment->id }}">{{ $comment->likes->count() }}</span>
                    @if(Auth::check())
                        @if(Auth::user()->commentLikes->contains('comment_id', $comment->id))
                            <button class="like-btn {{ Auth::user()->commentLikes->contains('comment_id', $comment->id) ? 'liked' : '' }}" id="like-btn-{{ $comment->id }}" data-comment-id="{{ $comment->id }}" data-liked="true">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        @else
                            <button class="like-btn" id="like-btn-{{ $comment->id }}" data-comment-id="{{ $comment->id }}" data-liked="false">
                                <i class="fa-solid fa-heart"></i>
                            </button>
                        @endif
                    @endif
                </div>


                    </div>
                        <p class="bodyText">{{ $comment->body }}</p>

                    

                </li>
            @endforeach
        </ul>
    @else
        <p>Žádné komentáře</p>
    @endif
</div>




<div id="sharePostModal" class="modal">
    <div class="modal-content">
    <span class="close">&times;</span>
        <h2>Sdílet Příspěvek</h2>

        <ul>
            <li><a class="facebook"><i class="fa-brands fa-facebook"></i></a></li>
            <li><a class="messenger"><i class="fa-brands fa-facebook-messenger"></i></a></li>
            <li><a class="twitter"><i class="fa-brands fa-twitter"></i></a></li>
            <li><a class="email"><i class="fa-solid fa-envelope"></i></a></li>
            <li><a class="whatsapp"><i class="fa-brands fa-whatsapp"></i></a></li>
        </ul>


        <div class="modal-share">

            <input type="text" id="urlInput" value="http://example.com">
            <a id="copy-btn">Zkopírovat</a>
        </div>
        <p class="alert alert-success" style="opacity: 0;">Odkaz zkopírován do schránky!</p>

                
    </div>
</div>


</div>


@endsection


@section('scripts')
<script>
    $(document).ready(function(){

    // Nastavení globálních AJAX headers pro CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    //odebrani :focus od tlacitka po kliknuti
    $('.like button, .like .like-btn').on('click', function() {
    const button = $(this);
    setTimeout(function() {
      // Zrušte :focus stav na tlačítku po uplynutí 1 sekundy
      button.blur();
    }, 500);
  });

    
    // Získáme odkaz na konkrétní příspěvek
    const postUrl = '{{ route('post.show', $post->id) }}';
        $('#urlInput').val(postUrl);

        // Funkce pro kopírování adresy URL do schránky
        function copyToClipboard(text) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);
        }

        // Event listener pro kliknutí na tlačítko "Zkopírovat"
        $('#copy-btn').click(function() {
        copyToClipboard(postUrl);
        $('.alert').animate({opacity: 1}, 500, function() {
            setTimeout(function() {
                $('.alert').animate({opacity: 0}, 500);
            }, 2000);
        });
    });


        // Sdílení na sociálních sítích
        const shareText = encodeURIComponent('Podívejte se na tento příspěvek: ');

        $('a.facebook').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(postUrl));
        $('a.messenger').attr('href', 'fb-messenger://share?link=' + encodeURIComponent(postUrl));
        $('a.twitter').attr('href', 'https://twitter.com/intent/tweet?text=' + shareText + '&url=' + encodeURIComponent(postUrl));
        $('a.email').attr('href', 'mailto:?subject=' + shareText + '&body=' + encodeURIComponent(postUrl));
        $('a.whatsapp').attr('href', 'whatsapp://send?text=' + shareText + encodeURIComponent(postUrl));


    $(window).on("click", function(event) {
        if (event.target == $("#sharePostModal")[0]) {
            $("#sharePostModal").fadeOut();
        }
    });

    $(".sharePost").on("click", function(){
        $("#sharePostModal").fadeIn();
    });

    $(".close").on("click", function(){
        $("#sharePostModal").fadeOut();
    });



//lajkování a odlajkování příspěvku
$('form[data-action]').on('submit', function (event) {
    event.preventDefault();

    const form = $(this);
    const action = form.data('action');
    const method = form.data('method') || 'POST';
    const csrfToken = form.find('input[name="_token"]').val();

    const likeButton = form.find('button');
    const isLiked = likeButton.data('liked') === true; // Změna z 'true' na true

    $.ajax({
        url: action,
        method: method,
        data: {
            _token: csrfToken,
        },
        success: function (response) {
            // Aktualizuj počet likes a stav tlačítka (přidejte nebo odeberte třídu 'liked')
            const likeCount = form.closest('.like').find('span');
            const newLikeCount = response.likes;

            likeCount.text(newLikeCount);

            if (isLiked) {
                form.data('action', response.likeUrl);
                form.data('method', 'POST');
                likeButton.data('liked', false); // Změna z 'false' na false
                likeButton.removeClass('liked');
            } else {
                form.data('action', response.unlikeUrl);
                form.data('method', 'DELETE');
                likeButton.data('liked', true); // Změna z 'true' na true
                likeButton.addClass('liked');
            }
        },
        error: function (xhr, status, error) {
            console.error('Chyba při odesílání like/unlike:', error);
        },
    });
});






    // Lajkování a odlajkování komentářů
function addLikeEventListener(likeButton) {  
    likeButton.on('click', function () {
    const commentId = $(this).data('comment-id');
    const isLiked = $(this).data('liked');
    const likesCountElement = $('#likes-count-' + commentId);
    const likesCount = parseInt(likesCountElement.text());

    if (isLiked) {
        // Odlajkovat komentář
        $.ajax({
            type: 'DELETE',
            url: '/comments/' + commentId + '/unlike',
            success: function (response) {
                // Aktualizuj počet lajků a změňte tlačítko na "nelajkované"
                likesCountElement.text(parseInt(likesCountElement.text()) - 1);
                $('#like-btn-' + commentId).data('liked', false);
                $('#like-btn-' + commentId).removeClass('liked');
            },
            error: function (response) {
                console.log('Chyba při odlaikování komentáře: ', response);
            }
        });

    } else {
        // Lajknout komentář
        $.ajax({
            type: 'POST',
            url: '/comments/' + commentId + '/like',
            success: function (response) {
                // Aktualizuj počet lajků a změňte tlačítko na "lajkované"
                likesCountElement.text(parseInt(likesCountElement.text()) + 1);
                $('#like-btn-' + commentId).data('liked', true);
                $('#like-btn-' + commentId).addClass('liked');
            },
            error: function (response) {
                console.log('Chyba při lajkování komentáře: ', response);
            }
        });

    }
});
}

$('.like-btn').each(function () {
    addLikeEventListener($(this));
});


// Odesílání komentáře klávesou Enter
$('#body').on('keydown', function (event) {
        // Kontrola, zda byla stisknuta klávesa Enter
        if (event.key === 'Enter') {
            event.preventDefault(); // Zabranit výchozímu chování, jako je vytváření nového řádku
            $('#add-comment-form button[type="submit"]').click(); // Spustit akci odeslání komentáře
        }
    });



// Přidávání komentářů
$('#add-comment-form').on('submit', function (e) {
    e.preventDefault(); // Zamezit obnovení stránky

    const postId = $(this).data('post-id');
    const body = $('#body').val();
    const _token = $('input[name=_token]').val();

    $.ajax({
    type: 'POST',
    url: '/posts/' + postId + '/comments',
    data: {
        body: body,
    },
    success: function (response) {
        // console.log('Komentář úspěšně přidán: ', response);

        // Vytvořit HTML pro nový komentář
        let newCommentHtml = `
            <li>
                <div class="header">
                    <div class="photo" style="background-image: url('/profile_images/${response.user.profile_image}');"></div>
                    <div class="text">
                        <a class="a text-tertiary" href="/user/${response.user_id}"><h4 class="a text-tertiary">${response.user.name}</h4></a>
                        <span class="comment-time">Právě teď</span>
                    </div>
                    <div class="like">
                    <span id="likes-count-${response.comment_id}">0</span>
                    <button class="like-btn" id="like-btn-${response.comment_id}" data-comment-id="${response.comment_id}" data-liked="false">
                        <i class="fa-solid fa-heart"></i>
                    </button>
                </div>
                </div>
                <p class="bodyText">${response.body}</p>
            </li>
        `;

        // Přidání nového komentáře do seznamu a vyčištění textového pole
        $('.comments-list').prepend(newCommentHtml);
        $('#body').val('');

        const newLikeButton = $('#like-btn-' + response.comment_id);
        addLikeEventListener(newLikeButton);
    },
    error: function (response) {
        console.log('Chyba při přidávání komentáře: ', response);
    }

    
});

});



    });
</script>
@endsection