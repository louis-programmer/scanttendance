<!DOCTYPE html>
<html>
<head>
    <title>Scan Terminal - Scanttendance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('css/app.css') }}"> 

   <style>
      
    </style>
</head>

<body>

<!-- LIVE STACK -->
<div id="scanStack"></div>

<!-- SINGLE TERMINAL CARD -->
<div class="scan-wrapper">

    <div class="scan-card-main">

        <!-- HEADER -->
        <h2 class="scan-title">Scanttendance</h2>
        <div class="scan-subtitle">RFID / Barcode / NFC Terminal</div>

        <!-- PULSE -->
        <div class="pulse-ring"></div>

        <!-- SCAN INPUT ONLY -->
        <form method="POST" action="/scan" id="scanForm">
            @csrf
            <input type="hidden" name="gate" value="Gate A">

            <input 
                type="text" 
                name="attendance_code" 
                id="scanner"
                class="scan-input"
                placeholder="Ready to scan..."
                autocomplete="off"
            >
        </form>

        <!-- STATUS -->
        <div class="status" id="status"></div>

        <!-- BACK -->
        <div class="scan-footer">
            <a href="/dashboard" class="back-btn">← Back to Dashboard</a>
        </div>

    </div>

</div>

<script>
const scanner = document.getElementById('scanner');
const form = document.getElementById('scanForm');
const stack = document.getElementById('scanStack');

window.onload = () => scanner.focus();
document.addEventListener('click', () => scanner.focus());

scanner.addEventListener('blur', () => {
    setTimeout(() => scanner.focus(), 50);
});

scanner.addEventListener('input', async function () {

    if (this.value.length < 4) return;

    let formData = new FormData(form);

    let res = await fetch("/scan", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
            "Accept": "application/json"
        },
        body: formData
    });

    let data = await res.json();

    showCard(data);

    this.value = "";
    scanner.focus();
});

const beep = new Audio('/beep.mp3');

function showCard(data) {

    beep.play();

    let type = (data.status === 'IN') ? 'in' : 'out';

    let card = document.createElement("div");
    card.className = `scan-card ${type}`;

    card.innerHTML = `
        <div class="scan-name">${data.name}</div>
        <div class="scan-status">${data.status}</div>
        <div class="scan-meta">${data.gate} • ${data.time}</div>
    `;

    stack.prepend(card);

    if (stack.children.length > 5) {
        stack.lastChild.remove();
    }

    setTimeout(() => {
        card.classList.add("fade-out");
        setTimeout(() => card.remove(), 400);
    }, 3000);
}
</script>

</body>
</html>