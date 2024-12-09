<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css') <!-- Ensure Tailwind is included -->
</head>
<body class="bg-gradient-to-b from-[#5F68E2] to-[#34397c] min-h-screen bg-cover">

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
            <a href="{{ route('profile-view') }}" class="text-black font-medium text-lg">Profile</a>
        </div>
        <div class="pfp">
            <a href="{{ route('profile') }}">
                <img src="assets/pfp.png" alt="Profile Picture" class="h-10 rounded-full">
            </a>
        </div>
    </div>

    <!-- Main content -->
    <div class="text-center my-10 mx-5">
        <h2 class="text-white text-2xl font-light mb-5">bosen? main yuk.</h2>
        <div class="flex justify-center gap-7 flex-wrap">
            <a href="{{ route('catcher') }}" class="bg-white rounded-xl p-5 shadow-lg transition-transform transform hover:translate-y-[-10px] text-decoration-none w-full max-w-[300px] mx-2">
                <img src="assets/catcher.png" alt="Catcher Game" class="h-64 mb-4">
                <h3 class="text-black text-2xl font-bold">CATCHER</h3>
            </a>
            <a href="{{ route('aim-trainer') }}" class="bg-white rounded-xl p-5 shadow-lg transition-transform transform hover:translate-y-[-10px] text-decoration-none w-full max-w-[300px] mx-2">
                <img src="assets/aim-trainer.png" alt="Aim Trainer Game" class="h-64 mb-4">
                <h3 class="text-black text-2xl font-bold">AIM TRAINER</h3>
            </a>
            <a href="{{ route('memory-tap') }}" class="bg-white rounded-xl p-5 shadow-lg transition-transform transform hover:translate-y-[-10px] text-decoration-none w-full max-w-[300px] mx-2">
                <img src="assets/memory-tap.png" alt="Memory Tap Game" class="h-64 mb-4">
                <h3 class="text-black text-2xl font-bold">MEMORY TAP</h3>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-5 bg-opacity-20 bg-white text-white text-sm">
        <a href="{{ route('about') }}" class="text-white font-medium mr-2 hover:underline">about</a>
        <p>© 2024 it.fun | All rights reserved.</p>
    </footer>
</body>
</html>
