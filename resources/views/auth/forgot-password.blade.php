<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css') <!-- Ensure Tailwind is included -->
</head>
<body class="min-h-screen bg-gradient-to-b from-[#5F68E2] to-[#34397C] flex justify-center items-center font-fredoka">
    <div class="bg-white rounded-lg p-8 shadow-lg w-full max-w-md">
        <h1 class="text-center text-2xl font-semibold text-gray-800 mb-6">Forgot Password</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" class="space-y-5">
            @csrf  <!-- Add CSRF token for security -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-700 focus:ring-[#5F68E2] focus:border-[#5F68E2]">
            </div>
            <div>
                <input type="submit" value="Send Password Reset Link"
                       class="w-full py-2 px-4 bg-[#5F68E2] text-white font-semibold rounded-md hover:bg-[#4b54d3] cursor-pointer transition">
            </div>
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-[#5F68E2] hover:underline font-medium">Remembered your password? Login</a>
            </div>
        </form>        
    </div>
    <footer class="absolute bottom-0 left-0 w-full bg-white/20 text-white text-center py-4">
        <a href="{{ url('/about') }}" class="text-white font-medium hover:underline">about</a>
        <p>© 2024 it.fun | All rights reserved.</p>
    </footer>
</body>
</html>
