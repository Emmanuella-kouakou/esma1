<?php
session_start();
include "../config/database.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM admin WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if($admin && $password == $admin['mot_de_passe']) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_nom'] = $admin['nom'];

        header("Location: ../admin/admin_dash.php"); 
        exit();
    } else {
        $message = "Email ou mot de passe incorrect";
    }
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Admin ESMA</title>
    <link rel="stylesheet" href="../assets/css/login-admin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-logo">
                <img src="../assets/images/logo-esma.png" alt="Logo ESMA" height="50">
            </div>
            <h2>Administration</h2>
            <p>Veuillez vous connecter pour continuer</p>
            
            <form method="POST">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" required>
                </div>
                <div class="input-group">
                    <label>Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-login">Se connecter</button>
            </form>
            <?php if($message) echo "<p style='color:red;'>$message</p>"; ?>
            
        </div>
    </div>
</body>
</html>



