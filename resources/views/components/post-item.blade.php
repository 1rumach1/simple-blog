@props(['post'])

<article class="flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="{{ route('view', ['post' => $post->slug]) }}" class="bg-white hover:opacity-75 w-full">
        <img src="{{ $post->getThumbnail() }}" class="aspect-[4/3] object-contain">
    </a>

    <div class="bg-white flex flex-col justify-start p-6">
        <div class="flex gap-4">
            @foreach ($post->categories as $category)
                <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">{{ $category->title }}</a>
            @endforeach
        </div>
        <a href="{{ route('view', ['post' => $post->slug]) }}" class="text-3xl font-bold hover:text-gray-700 pb-4">
            {{ $post->title }}
        </a>

        <p class="text-sm pb-3">
            By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>,
            Published on {{ $post->published_at->format('F j, Y') }} | {{ str_word_count($post->body) }} words
        </p>

        <a href="{{ route('view', ['post' => $post->slug]) }}" class="pb-6">
            {{ $post->shortBody() }}
        </a>

        <a href="{{ route('view', ['post' => $post->slug]) }}" class="uppercase text-gray-800 hover:text-black">
            Continue Reading <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</article>
