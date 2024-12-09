<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
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

    <!-- Leaderboard -->
    <div class="text-center my-10 mx-5">
        <h2 class="text-white text-3xl font-light mb-5">Leaderboard</h2>
        <div class="overflow-x-auto bg-white p-5 rounded-xl shadow-lg max-w-4xl mx-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">Username</th>
                        <th class="border border-gray-300 px-4 py-2">Game</th>
                        <th class="border border-gray-300 px-4 py-2">Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scores as $score)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="border border-gray-300 px-4 py-2">{{ $score->username }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $score->game }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if($score->game === 'Aim Trainer')
                                {{ $score->score }} ms
                            @elseif($score->game === 'Catcher')
                                {{ $score->score }} pts
                            @else
                                {{ $score->score }} rds
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            
            
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-5 bg-opacity-20 bg-white text-white text-sm">
        <a href="{{ route('about') }}" class="text-white font-medium mr-2 hover:underline">about</a>
        <p>© 2024 it.fun | All rights reserved.</p>
    </footer>
</body>
</html>
