<x-app-layout>
    <!-- Post Section -->
    <section class="w-full md:w-2/3 flex flex-col  px-3">
        <article class="flex flex-col shadow my-4">
            <!-- Article Image -->
            <a href="#" class="hover:opacity-75">
                <img src="{{ $post->getThumbnail() ?? asset('default-thumbnail.jpg') }}" alt="Post Thumbnail">
            </a>
            <div class="bg-white flex flex-col justify-start p-6">
                <div class="flex gap-4">
                    @foreach ($post->categories as $category)
                        <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">{{ $category->title }}</a>
                    @endforeach
                </div>

                <h1 href="#" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $post->title }}</h1>
                <p href="#" class="text-sm pb-8">
                    By <a href="#" class="font-semibold hover:text-gray-800">{{ $post->user->name }}</a>, Published on
                    {{ $post->published_at->format('F j, Y') }} | {{ str_word_count($post->body) }} words
                </p>
                <div>
                    {!! $post->body !!}
                </div>
                <br>
                <livewire:upvote-downvote :post="$post"/>
            </div>
        </article>

        <div class="w-full flex pt-6">
            <div class="w-1/2">
                @if($prev)
                    <a href="{{ route('view', ['post' => $prev->slug]) }}"
                        class="block w-full bg-white shadow hover:shadow-md text-left p-6">
                        <p class="text-lg text-blue-800 font-bold flex items-center"><i class="fas fa-arrow-left pr-1"></i>
                            Previous</p>
                        <p class="pt-2">{{ \Illuminate\Support\Str::words($prev->title, 5)}}</p>
                    </a>
                @endif
            </div>
            <div class="w-1/2">
                @if($next)
                    <a href="{{ route('view', ['post' => $next->slug]) }}"
                        class="block w-full bg-white shadow hover:shadow-md text-right p-6">
                        <p class="text-lg text-blue-800 font-bold flex items-center justify-end">Next <i
                                class="fas fa-arrow-right pl-1"></i></p>
                        <p class="pt-2">{{ \Illuminate\Support\Str::words($next->title, 5)}}</p>
                    </a>
                @endif
            </div>
        </div>

        <livewire:comments :post="$post"/>
    </section>
    <x-sidebar />
</x-app-layout>
