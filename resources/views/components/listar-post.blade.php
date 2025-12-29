<div>
    @if($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ( $posts as $post )
                <div class="flex justify-center">
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img class="h-80" src="{{ asset('uploads') . '/' . $post->imagen}}" alt="Imagen del Post {{ $post->titulo }}">
                    </a>

                </div>
            @endforeach
        </div>

        <div class="my-10">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-center">No hay posts, sigue a alguien para poder ver sus posts</p>
    @endif
</div>