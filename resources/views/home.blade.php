<?php
/** @var $posts Illuminate\Pagination\LengthAwarePaginator */
?>

<x-app-layout>
    <div class="container max-w-6xl mx-auto  py-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
            <!--Latest Post -->
            <div class="col-span-2">
                <h2 class="text-lg sm:text-xl font-bold text-blue-800 mb-3 uppercase pb-1 border-b-2 border-blue-800">
                    Latest Post
                </h2>
                <div>
                    <x-post-item :post="$latestPosts" />
                </div>
            </div>

            <!--Popular Post -->
            <div class="mb-5">
                <h2 class="text-lg sm:text-xl font-bold text-blue-800 mb-3 uppercase pb-1 border-b-2  border-blue-800">
                    Popular Post
                </h2>
                @foreach ($popularPosts as $post)
                    <div class="bg-white rounded-lg shadow-md p-3 mb-4">
                        <div class="grid grid-cols-4 gap-2">
                            <a href="{{route('view', $post)}}" class="pt-1">
                                <img src="{{ $post->getThumbnail() }}" alt="{{ $post->title }}" class="rounded" />
                            </a>
                            <div class="col-span-3">
                                <h3 class="text-sm uppercase whitespace-nowrap truncate">
                                    {{ $post->title }}
                                </h3>
                                <div class="flex gap-4 mb-2">
                                    @foreach ($post->categories as $category)
                                        <a href="#" class="bg-blue-500 text-white p-1 rounded text-xs font-bold uppercase">
                                            {{ $category->title }}
                                        </a>
                                    @endforeach
                                </div>
                                <div class="text-xs">
                                    {{ $post->shortBody(10) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- recomended post --}}
        <div class="mb-5">
            <h2 class="text-lg sm:text-xl font-bold text-blue-800 mb-3 uppercase pb-1 border-b-2  border-blue-800">
                Recomended Post
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @foreach ($recommendedPosts as $rpost)
                    <x-post-item :post="$rpost" />
                @endforeach

            </div>
        </div>

        {{-- Latest Categories --}}
        @foreach ($categoriesPost as $category)
            <div>
                <h2 class="text-lg sm:text-xl font-bold text-blue-800 mb-3 uppercase pb-1 border-b-2  border-blue-800">
                    {{$category->title}}
                    <a href="{{route('by-category', $category)}}"><i class="fas fa-arrow-right"></i></a>
                </h2>

                <div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @foreach ($category->publishedPosts()->limit(3)->get() as $cpost)
                            <x-post-item :post="$cpost" />
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
