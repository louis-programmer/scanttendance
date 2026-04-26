@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@if(session('error'))
    <p>{{ session('error') }}</p>
@endif

<form method="POST" action="/scan">
    @csrf
    <input type="text" name="barcode" autofocus placeholder="Scan or type ID">
</form>  