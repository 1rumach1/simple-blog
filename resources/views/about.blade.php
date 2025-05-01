<x-app-layout>
        <section class="w-full w- flex flex-col items-center px-3">
            <article class="flex flex-col shadow my-4">
                <a href="{{route('about-us')}}" class="hover:opacity-75">
                    <img src="{{ asset('storage/' . $widget->image) }}" alt="An Image" class="w-full">
                </a>
                <div class="bg-white flex flex-col justify-start p-6">
                    <h1 href="#" class="text-3xl font-bold hover:text-gray-700 pb-4">{{ $widget->title }}</h1>
                    <div>
                        {!! $widget->content !!}
                    </div>
                </div>
            </article>
        </section>
</x-app-layout>
