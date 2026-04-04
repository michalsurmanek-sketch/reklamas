<?php
require_once 'config.php';

$error = '';

if (isLoggedIn()) {
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
        $_SESSION['reklamas_logged_in'] = true;
        $_SESSION['reklamas_username'] = $username;

        header('Location: admin.php');
        exit;
    } else {
        $error = 'Neplatné přihlašovací údaje.';
    }
}
?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Přihlášení | Reklamas Admin</title>
  <meta name="theme-color" content="#facc15" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Montserrat', sans-serif; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-yellow-50 via-white to-white text-black">
  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md rounded-[28px] border border-black/10 bg-white shadow-sm overflow-hidden">
      <div class="bg-black text-white px-6 py-5">
        <div class="text-xs uppercase tracking-[0.25em] text-yellow-300">Reklamas Admin</div>
        <h1 class="text-2xl font-extrabold mt-1">Přihlášení do adminu</h1>
        <p class="text-white/70 mt-2">Pouze pro interní správu Reklamas.cz</p>
      </div>

      <div class="p-6">
        <?php if ($error): ?>
          <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
          </div>
        <?php endif; ?>

        <form method="post" class="space-y-4">
          <div class="space-y-2">
            <label class="block text-sm font-semibold">Uživatelské jméno</label>
            <input
              type="text"
              name="username"
              required
              class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black"
              placeholder="Zadej jméno"
            />
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold">Heslo</label>
            <input
              type="password"
              name="password"
              required
              class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black"
              placeholder="Zadej heslo"
            />
          </div>

          <button
            type="submit"
            class="w-full rounded-2xl bg-yellow-400 px-5 py-3 font-bold text-black transition hover:bg-yellow-300"
          >
            Přihlásit se
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
