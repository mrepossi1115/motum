<!-- resources/views/auth/login.blade.php -->
<form action="{{ route('login') }}" method="POST">
    @csrf
    <label for="email">Email</label>
    <input type="email" name="email" required>
    <label for="password">Password</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
<a href="{{ route('registerTrainer') }}">Eres entrenador? Registrate</a>

