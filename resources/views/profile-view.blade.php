<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="font-fredoka bg-gradient-to-b from-[#5F68E2] to-[#34397c] min-h-screen flex flex-col">

    <!-- Navigation bar -->
    <div class="flex justify-between items-center px-5 py-2 bg-white border-b-2 border-gray-300">
        <div class="logo">
            <a href="{{ route('dashboard') }}">
                <img src="assets/logo.png" alt="Logo" class="h-10">
            </a>
        </div>
        <div class="flex gap-5">
            <a href="{{ route('dashboard') }}" class="text-black font-medium text-lg">Home</a>
            <a href="{{ route('scores') }}" class="text-black font-medium text-lg">Scores</a>
            <a href="{{ route('profile') }}" class="text-black font-medium text-lg">Profile</a>
        </div>
        <div class="pfp">
            <a href="{{ route('profile') }}">
                <img src="assets/pfp.png" alt="Profile Picture" class="h-10 rounded-full">
            </a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="flex-grow flex justify-center items-center px-4 py-8">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-center mb-4">Profile</h1>
            
            <!-- Profile Picture -->
            <div class="flex flex-col items-center mb-6">
                <img src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : 'assets/default.png' }}" 
                    alt="Profile Picture" 
                    class="h-24 w-24 rounded-full shadow-lg border-4 border-gray-300 object-cover">
            </div>
            
            <!-- Profile Information -->
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-medium">Name:</span>
                    <span class="text-gray-900">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-medium">Email:</span>
                    <span class="text-gray-900">{{ Auth::user()->email }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-medium">Password:</span>
                    <span class="text-gray-900">********</span>
                </div>
            </div>

            <!-- Edit and Logout Buttons -->
            <div class="mt-6 flex flex-col gap-4">
                <a href="{{ route('profile') }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow-md">
                    Edit Profile
                </a>
                <form action="{{ route('logout') }}" method="POST" class="text-center">
                    @csrf
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-red font-medium py-2 px-4 rounded-lg shadow-md">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
