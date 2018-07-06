<?php session_start();
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
echo "<html>
<head>
<title>Sistema de Gestion de Tintas y Toners</title>
<link href=\"estilos.css\" rel=\"stylesheet\" type=\"text/css\" />
</head>
<body>
<br>
<h3 align='center'>Ha salido del Sistema de Gestion de Tintas y Toners.</h2>
<h4 align='center'><span class='boton'><a class='enlace' href='index.php'>Reingresar</a></span></h4>
</body>
</html>";
?>
