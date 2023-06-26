<div class="post animate__animated animate__fadeInLeft" data-id="{{ $post->id }}">
<p><i class="fa-regular fa-calendar"></i> {{ $post->created_at->setTimeZone('Europe/Prague')->format('d. m. Y H:i') }}</p>
    <a class="a none" href="{{ route('post.show', ['id' => $post->id]) }}">
        <div class="post_content">
            <h3>{{ $post->id }}</h3>
            <h3 class="title">{{ $post->title }}</h3>
            <p class="description">{{ $post->description }}</p>
            <p class="content">{{ Str::words(strip_tags($post->content), 40) }}</p>
        </div>
    </a>
    <div class="post-info">
            <div class="post-user">
                <div class="photo"  style="background-image: url('/profile_images/{{ $post->user->profile_image }}');"></div>
                <a class="a text-tertiary" href="{{ route('profile.show', ['id' => $post->user->id]) }}">{{ $post->user->name }}</a>
            </div>
            <div class="post-stats">
                <span><i class="icon fa-regular fa-comment"></i> {{ $post->comments_count }}</span>
                <span><i class="icon fa-regular fa-heart"></i> {{ $post->likes_count }}</span>
                <span><i class="icon fa-solid fa-users"></i> {{ $post->views }} </span>
            </div>           
    </div>
</div>