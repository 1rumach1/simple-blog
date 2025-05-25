<x-guest-layout>
    <div class="flex justify-center mb-6">
        <img src="{{ asset('storage/blue.jpg') }}" alt="Shipping Company Logo" class="h-16">
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input
                id="name"
                class="block mt-1 w-full border-teal-300 focus:border-teal-500 focus:ring-teal-500"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                class="block mt-1 w-full border-teal-300 focus:border-teal-500 focus:ring-teal-500"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input
                id="password"
                class="block mt-1 w-full border-teal-300 focus:border-teal-500 focus:ring-teal-500"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full border-teal-300 focus:border-teal-500 focus:ring-teal-500"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-teal-700 hover:text-teal-900" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-teal-600 hover:bg-teal-700 text-white ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
