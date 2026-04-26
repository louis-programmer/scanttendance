<!DOCTYPE html>
<html>
<head>
    <title>Scanttendance Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --bg: #f5f6fa;
            --card: #ffffff;
            --text: #2f3640;
            --muted: #718093;
            --primary: #0984e3;
            --danger: #e84118;
            --nav: #2f3640;
        }

        body.dark {
            --bg: #0f141a;
            --card: #1c1f26;
            --text: #ffffff;
            --muted: #aaa;
            --nav: #151a22;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
            transition: 0.3s;
        }

        /* NAVBAR */
        .navbar {
            background: var(--nav);
            color: white;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* CONTAINER */
        .container {
            padding: 25px;
            max-width: 1000px;
            margin: auto;
        }

        /* CARDS */
        .card {
            background: var(--card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: 0.3s;
        }

        h2, h3 {
            margin-top: 0;
        }

        p {
            color: var(--muted);
        }

        /* BUTTONS */
        .btn {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            background: var(--primary);
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
        }

        /* SMALL UI */
        .tag {
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 6px;
            background: rgba(9,132,227,0.1);
            color: var(--primary);
        }

        /* TOGGLE */
        .toggle {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="navbar">
    <div class="brand">Scanttendance</div>

    <div class="nav-actions">

        <button class="toggle" onclick="toggleDark()">🌓</button>

        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>

    </div>
</div>

<div class="container">

    <!-- WELCOME CARD -->
    <div class="card">
        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <p>You are logged in to the attendance system.</p>
        <span class="tag">Secure Session Active</span>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="card">
        <h3>Quick Actions</h3>

        <div class="grid">
            <a href="/scan" class="btn">📡 Open Scanner</a>
            <a href="#" class="btn">📊 View Logs (soon)</a>
            <a href="#" class="btn">👥 Users (soon)</a>
        </div>
    </div>

    <!-- SYSTEM STATUS -->
    <div class="card">
        <h3>System Status</h3>
        <p>Attendance Engine: <strong>Active</strong></p>
        <p>Database: <strong>Connected</strong></p>
        <p>Scan Mode: <strong>Ready</strong></p>
    </div>

</div>

<script>
    // Dark mode toggle (persistent)
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