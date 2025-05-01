<!-- Top Bar Nav -->
<nav class="w-full bg-blue-700 shadow">
    <div class="w-full container mx-auto flex items-center justify-between py-2">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center">
            <img src="{{ asset('storage/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain ml-4"> <!-- adjust h-10 as needed -->
        </a>
        <!-- Right Links -->
        <div class="flex items-center gap-4 text-white text-sm font-semibold uppercase">
            <a href="#" class="hover:underline hover:text-gray-200">My Profile</a>
            <a href="#" class="hover:underline hover:text-gray-200 mr-4">Logout</a>
        </div>
    </div>
</nav>
