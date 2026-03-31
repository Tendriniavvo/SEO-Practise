<?php
session_start();
require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // On accepte password_verify (pour les futurs hashs) OU le SHA256 brut du SQL
    if ($user && (password_verify($password, $user['password']) || hash('sha256', $password) === $user['password'])) {
        $_SESSION['admin_id'] = $user['id_admin'];
        $_SESSION['admin_user'] = $user['username'];
        header("Location: index.php?page=dashboard");
        exit();
    } else {
        $error = "Identifiants invalides.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Connexion Administration - Iran News</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="/front/assets/css/style.css">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: var(--light);
    }
    .login-box {
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      border-top: 4px solid var(--red);
    }
    .login-box h1 {
      font-size: 24px;
      font-weight: 800;
      margin-bottom: 8px;
      text-align: center;
    }
    .login-box p.subtitle {
      text-align: center;
      color: #666;
      font-size: 14px;
      margin-bottom: 30px;
    }
    .error {
      background: #fff0f2;
      color: var(--red);
      padding: 12px;
      border-radius: 6px;
      font-size: 13px;
      margin-bottom: 20px;
      border: 1px solid #ffccd2;
      font-weight: 600;
    }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 14px; }
    input {
      width: 100%;
      padding: 12px;
      border: 1.5px solid var(--border);
      border-radius: 8px;
      font-family: 'Sora', sans-serif;
      font-size: 14px;
      background: #fdfdfd;
      transition: all 0.2s;
    }
    input:focus {
      border-color: var(--red);
      outline: none;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(232, 0, 29, 0.1);
    }
    button {
      width: 100%;
      padding: 14px;
      background: var(--red);
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 700;
      cursor: pointer;
      font-family: 'Sora', sans-serif;
      font-size: 15px;
      margin-top: 10px;
      transition: opacity 0.2s;
    }
    button:hover { opacity: 0.9; }
    .footer-note {
      text-align: center;
      margin-top: 25px;
      font-size: 12px;
      color: #999;
    }
  </style>
</head>
<body>
    <div class="login-box">
        <h1>ADMIN<span>IRAN</span></h1>
        <p class="subtitle">Connectez-vous pour gérer les contenus</p>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required  value="admin">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required value="admin123">
            </div>
            <button type="submit">Se connecter</button>
        </form>
        
        <div class="footer-note">
            Accès réservé au personnel autorisé.<br>
            <small>Défaut: admin / admin123</small>
        </div>
    </div>
</body>
</html>
