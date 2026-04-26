<!DOCTYPE html>
<html>
<head>
    <title>Scanttendance Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            transition: 0.3s;
            background: linear-gradient(135deg, #2f3640, #353b48);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        body.dark {
            background: #0f141a;
        }

        .card {
            background: white;
            padding: 35px;
            width: 100%;
            max-width: 380px;
            border-radius: 14px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            text-align: center;

            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.6s ease forwards;
        }

        body.dark .card {
            background: #1c1f26;
            color: white;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 10px;
            border-radius: 50%;
            background: #0984e3;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
            box-shadow: 0 0 20px rgba(9,132,227,0.5);
        }

        h2 {
            margin: 10px 0 20px;
        }

        .scan-vibe {
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, transparent, #00a8ff, transparent);
            margin-bottom: 20px;
            animation: scan 1.5s infinite linear;
        }

        @keyframes scan {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        body.dark input {
            background: #2a2f3a;
            border: 1px solid #444;
            color: white;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #0984e3;
            border: none;
            color: white;
            font-size: 15px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #0769b5;
        }

        .error {
            background: #ff7675;
            color: white;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .toggle {
            margin-top: 12px;
            font-size: 12px;
            cursor: pointer;
            color: #888;
        }

        body.dark .toggle {
            color: #aaa;
        }

        .footer {
            margin-top: 12px;
            font-size: 11px;
            color: #aaa;
        }
    </style>
</head>

<body>

<div class="card">

    <!-- Logo -->
    <div class="logo">S</div>

    <h2>Scanttendance</h2>

    <div class="scan-vibe"></div>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <!-- SECURITY: CSRF protected -->
    <form method="POST" action="/login">
        @csrf

        <input type="email" name="email" placeholder="Email" required autocomplete="username">

        <input type="password" name="password" placeholder="Password" required autocomplete="current-password">

        <button type="submit">Secure Login</button>
    </form>

    <div class="toggle" onclick="toggleDark()">
        Toggle Dark Mode
    </div>

    <div class="footer">
        Protected Access System
    </div>

</div>

<script>
    // Dark mode persistence
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark");
    }

    function toggleDark() {
        document.body.classList.toggle("dark");

        if (document.body.classList.contains("dark")) {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }
    }
</script>

</body>
</html>