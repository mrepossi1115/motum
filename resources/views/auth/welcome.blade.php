<!-- resources/views/auth/welcome.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
</head>
<body>
    <h1>Bienvenido</h1>
    <p>Por favor, selecciona una opción para continuar:</p>
    
    <a href="{{ route('login') }}" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">
        Iniciar Sesión
    </a>

    <a href="{{ route('register') }}" style="display: inline-block; padding: 10px 20px; margin: 10px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px;">
        Registrarse
    </a>
</body>
</html>
