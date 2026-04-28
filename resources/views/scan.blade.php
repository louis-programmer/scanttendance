<!DOCTYPE html> <!-- before editing -->
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
        <form method="POST" action="/scan" id="scanForm" onsubmit="return false;">
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
    /*
        Correct flow:
        Scanner types into input
        Either:
        presses Enter → triggers keypress
        OR stops typing → triggers input timeout
        processScan() runs
        Sends POST /scan
        Backend returns JSON
        showCard() displays result
        Input resets
    */
    
const scanner = document.getElementById('scanner');
const form = document.getElementById('scanForm');
const stack = document.getElementById('scanStack');

let isProcessing = false;

async function processScan() {

    // Handlessending request
    // validating response
    // updating UI

    if (isProcessing) return;
    isProcessing = true;

    let formData = new FormData(form);

    let res = await fetch("/scan", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name=_token]').value,
            "Accept": "application/json"
        },
        body: formData
    });

    let data;

    try {
        data = await res.json();
    } catch (e) {
        console.error("Invalid JSON response");
        isProcessing = false;
        return;
    }

    console.log(data);

    if (!data || !data.name) {
        console.error("Invalid response:", data);
        isProcessing = false;
        return;
    }

    showCard(data);

    scanner.value = "";
    scanner.focus();

    // setTimeout(() => isProcessing = false, 300); // If network is  slow, this might unlick too early
    isProcessing = false;
}


window.onload = () => scanner.focus();

    document.addEventListener('click', () => scanner.focus());

    scanner.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            processScan();
        }
    });

    let typingTimer;

    scanner.addEventListener('input', function () {
        clearTimeout(typingTimer);

        typingTimer = setTimeout(() => {
            if (this.value.length > 3) {
                processScan();
            }
        }, 100);
    });



const beep = new Audio('/beep.mp3');


function showCard(data) {

    beep.currentTime = 0;
    beep.play().catch(() => {});

    let type = 'out';

    if (data.status === 'IN') type = 'in';
    if (data.status === 'ERROR') type = 'error';
    if (data.status === 'TOO FAST') type = 'warning';

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