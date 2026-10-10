<h1>Kirim test pesan</h1>

<form action="{{ route('sendEmail') }}" method="POST">
    @csrf
    <button type="submit">Kirim Email</button>
    
</form>