<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Edit</title>
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
            <h1 class="text-2xl font-bold text-center mb-4">Edit Profile</h1>
            
            <!-- Profile Picture -->
            <form id="profilePictureForm" action="{{ route('profile.picture.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center">
                @csrf
                <div class="relative mb-6">
                    <img id="profilePicturePreview" src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : 'assets/default.png' }}" 
                        alt="Profile Picture" 
                        class="h-24 w-24 rounded-full shadow-lg border-4 border-gray-300 object-cover">
                    <input id="profilePictureInput" type="file" name="profile_picture" accept="image/*" 
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow-md">
                    Upload Picture
                </button>
            </form>
            

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input id="name" name="name" type="text" value="{{ Auth::user()->name }}" placeholder="Enter your name" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-300">
                </div>
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ Auth::user()->email }}" placeholder="Enter your email" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-300">
                </div>
                <!-- Change Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter new password" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-300">
                </div>
                <div class="mb-4">
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="confirmPassword" name="password_confirmation" type="password" placeholder="Confirm new password" class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-indigo-300">
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#5F68E2] hover:bg-[#34397c] text-white font-medium py-2 px-4 rounded-lg shadow-md transition">
                    Save Changes
                </button>
            </form>
            
            <form action="{{ route('logout') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-red font-medium py-2 px-4 rounded-lg shadow-md">
                    Logout
                </button>
            </form>
        </div>
    </div>

</body>
</html>
