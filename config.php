<?php
session_start();

/*
|--------------------------------------------------
| Přihlašovací údaje
|--------------------------------------------------
| Tady si změň jméno a heslo.
*/
$ADMIN_USERNAME = 'admin';
$ADMIN_PASSWORD = 'MojeSilneHeslo123!';

/*
|--------------------------------------------------
| Kontrola přihlášení
|--------------------------------------------------
*/
function isLoggedIn(): bool {
    return isset($_SESSION['reklamas_logged_in']) && $_SESSION['reklamas_logged_in'] === true;
}
?>
