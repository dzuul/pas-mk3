<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        /* Basic reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Fredoka', sans-serif;
    background: linear-gradient(to bottom, #5F68E2, #34397C);
    min-height: 100vh; /* Ensures the gradient covers the entire viewport height */
    background-size: 100% 100vh;
    margin: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Navigation bar */
.nav {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    background-color: #fff;
    border-bottom: 2px solid #ccc;
}

.logo-img {
    height: 60px;
}

/* Content section */
.content {
    text-align: center;
    margin: 50px auto;
    color: #fff;
    padding: 0 20px; /* Add padding to avoid content touching edges */
}

.content h1 {
    font-size: 36px;
    margin-bottom: 20px;
}

.content p {
    font-size: 18px;
    margin-bottom: 10px; /* Adjusted gap between lines */
    line-height: 1.4;    /* Tighter line spacing */
}

/* Footer */
footer {
    text-align: center;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
    font-size: 14px;
    position: relative;
    bottom: 0;
    width: 100%;
}

/* Media Queries for Responsive Design */

/* For tablets and larger mobile devices */
@media (max-width: 768px) {
    .content h1 {
        font-size: 28px; /* Adjust font size for smaller screens */
    }

    .content p {
        font-size: 16px; /* Adjust font size for smaller screens */
    }

    .logo-img {
        height: 50px; /* Adjust logo size for smaller screens */
    }

    .nav {
        padding: 15px;
    }
}

/* For smaller mobile devices */
@media (max-width: 480px) {
    .content h1 {
        font-size: 24px; /* Further adjust font size for very small screens */
    }

    .content p {
        font-size: 14px; /* Further adjust font size for very small screens */
    }

    .logo-img {
        height: 40px; /* Further adjust logo size for very small screens */
    }

    .nav {
        flex-direction: column;
        padding: 10px;
    }

    .content {
        margin: 20px auto;
        padding: 0 10px; /* Add padding for very small screens */
    }
}

    </style>
</head>
<body>
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

    <!-- About content -->
    <div class="content">
        <h1>About</h1>
        <p>it.fun itu website game buatan ian, galang, galih, sama rafi.</p>
        <p>web ini kami buat di jangka waktu sekitar 2 bulan termasuk desain figma, code vs code, dan gamenya.</p>
        <p>tujuan dari web ini tu ya buat dapet nilai, semoga aja bisa buat portofolio resume kerja nanti.</p>
        <p>sekedar fun fun aja. makasih udah liat web kami.</p>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2024 it.fun | All rights reserved.</p>
    </footer>
</body>
</html>
