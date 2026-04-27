<!DOCTYPE html>
<html>
<head>
    <title>Scanttendance Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/app.css">
    <style>
       
    </style>
</head>

<body>

<div class="navbar">
    <div class="brand">Scanttendance</div>

    <div class="nav-actions">

        <button class="toggle" onclick="toggleDark()">🌓 Theme</button>

        <form method="POST" action="/logout">
            @csrf
            <button class="btn btn-danger">Logout</button>
        </form>

    </div>
</div>

<div class="container">

    <!-- HERO WELCOME -->
    <div class="card hero">
        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <p>Attendance system is running smoothly.</p>
        <span class="tag">Secure Session Active</span>
    </div>

    <!-- GRID ACTIONS -->
    <div class="grid">

        <div class="card action-card">
            <h3>Scanner</h3>
            <p>Start attendance scanning</p>
            <a href="/scan" class="btn">📡 Open Scanner</a>
        </div>

        <div class="card action-card">
            <h3>Logs</h3>
            <p>View attendance history</p>
            <a href="#" class="btn">📊 View Logs</a>
        </div>

        <div class="card action-card">
            <h3>Users</h3>
            <p>Manage attendees</p>
            <a href="#" class="btn">👥 Manage Users</a>
        </div>

    </div>

    <!-- STATUS -->
    <div class="card status-card">
        <h3>System Status</h3>

        <div class="status-row">
            <span>Engine</span>
            <strong class="ok">Active</strong>
        </div>

        <div class="status-row">
            <span>Database</span>
            <strong class="ok">Connected</strong>
        </div>

        <div class="status-row">
            <span>Scan Mode</span>
            <strong class="ok">Ready</strong>
        </div>

    </div>

</div>

<script>
// load saved theme
if (localStorage.getItem("theme") === "light") {
    document.body.classList.add("theme-light");
}

function toggleDark() {
    document.body.classList.toggle("theme-light");

    localStorage.setItem(
        "theme",
        document.body.classList.contains("theme-light") ? "light" : "dark"
    );
}
</script>
</body>
</html>