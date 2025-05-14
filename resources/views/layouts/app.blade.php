<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOL Blog</title>
    <meta name="author" content="">
    <meta name="description" content="">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
    </style>
    <!-- AlpineJS v3 (latest stable) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-50 font-family-karla">

    @include('components.header')

    <!-- Text Header -->
    <header class="w-full bg-blue-500">
        <div class="container mx-auto flex flex-col items-center py-12">
            <a class="font-bold text-white uppercase hover:text-gray-100 text-7xl m-3" href="#">
                {{ \App\Models\TextWidget::getTitle('header') }}
            </a>
            <div class="text-white text-lg mb-0 prose prose-invert max-w-none text-center">
                {!! \App\Models\TextWidget::getContent('header') !!}
            </div>

        </div>
    </header>

    <!-- Topic Nav -->
    <nav class="w-full py-4 border-t border-b bg-gray-100" x-data="{ open: false }">
        <div class="block sm:hidden">
            <a href="#" class="block md:hidden text-base font-bold uppercase text-center  justify-center items-center"
                @click="open = !open">
                Topics <i :class="open ? 'fa-chevron-down': 'fa-chevron-up'" class="fas ml-2"></i>
            </a>
        </div>
        <div :class="{'hidden': !open}" class="w-full flex-grow sm:flex sm:items-center sm:w-auto">
            <div
                class="w-full container mx-auto flex flex-col sm:flex-row items-center justify-between text-sm font-bold uppercase mt-0 px-6 py-2">
                <div>
                    <a href="{{route('home')}}"
                        class="hover:bg-blue-600 rounded py-2 px-4 mx-2  hover:text-white">Home</a>
                    @foreach ($categories as $category)
                    <a href="{{route('by-category', $category)}}"
                        class="hover:bg-blue-600 rounded py-2 px-4 mx-2  hover:text-white">{{$category->title}}</a>
                    @endforeach
                    <a href="{{route('about-us')}}"
                        class="hover:bg-blue-600  hover:text-white rounded py-2 px-4 mx-2">About Us</a>

                </div>

                <div>
                    @auth
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="hover:bg-blue-600  hover:text-white rounded py-2 px-4 mx-2 flex items-center">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @else
                    <a href="{{route('login')}}"
                        class="hover:bg-blue-600  hover:text-white rounded py-2 px-4 mx-2">Login</a>
                    <a href="{{route('register')}}"
                        class="hover:bg-blue-600  hover:text-white rounded py-2 px-4 mx-2">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto flex flex-wrap py-6">
        {{$slot}}

        <div class="w-full flex flex-col text-center md:text-left md:flex-row shadow bg-white mt-10 mb-10 p-6">
            <div class="w-full md:w-1/5 flex justify-center md:justify-start pb-4">
                <img src="https://www.mol.co.jp/assets/img/logo_en.svg" class="rounded-full shadow h-32 w-32">
            </div>
            <div class="flex-1 flex flex-col justify-center md:justify-start">
                <p class="font-semibold text-2xl">Mitsui O.S.K. Lines. Ltd </p>
                <p class="pt-2">From the blue oceans, we sustain people's lives and ensure a prosperous future.</p>
                <div class="flex items-center justify-center md:justify-start text-2xl no-underline text-blue-800 pt-4">
                    <a class="" href="#">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a class="pl-4" href="#">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="pl-4" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="pl-4" href="#">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</body>

</html>
