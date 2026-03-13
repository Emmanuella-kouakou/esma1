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
    <title>Document</title> <link rel="stylesheet" href="../assets/css/login-admin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-form-side">
            <div class="brand">
                <div class="logo-box">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span>PORTAIL ÉDUCATIF</span>
            </div>

            <div class="form-content">
                <h1>Connexion Administration</h1>
                <p class="subtitle">Accès sécurisé au tableau de bord de gestion.</p>

                <form method="POST" action="">
                    <div class="input-group">
                        <label for="email">Identifiant</label>
                        <div class="input-wrapper">
                            <i class="far fa-user"></i>
                            <input type="text" name="email" id="email" placeholder="Ex: admin_results_2026">
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="label-row">
                            <label for="password">Mot de passe</label>
                            <a href="#" class="forgot-link">Mot de passe oublié ?</a>
                        </div>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" placeholder="••••••••">
                            <i class="far fa-eye toggle-password"></i>
                        </div>
                    </div>

                    <button type="submit" class="login-btn">
                        Se connecter <i class="fas fa-sign-in-alt"></i>
                    </button>
                </form>
                <?php if($message != ""){ ?> 
                <p style="color:red;"><?php echo $message; ?></p> 
                 <?php } ?>
               
            </div>

            <footer class="footer-left">
                <span>© 2026 ESMA</span>
                <div class="footer-links">
                    <a href="#">Aide</a>
                    <a href="#">Confidentialité</a>
                </div>
            </footer>
        </div>

        <div class="info-side">
            <div class="overlay"></div>
            <div class="info-content">
                <div class="shield-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h2>Système de Certification Sécurisé</h2>
                <p>Gérez l'intégrité des résultats académiques avec nos outils avancés de validation et de reporting en temps réel.</p>
                
                <div class="carousel-dots">
                    <span class="dot active"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </div>
    </div>
</body></html>



