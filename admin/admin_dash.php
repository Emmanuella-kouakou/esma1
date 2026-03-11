<?php
session_start();
include "../config/database.php";

// vérifier si admin connecté
if(!isset($_SESSION['admin_id'])){
    header("Location: ../admin/login_admin.php");
    exit();
}
 // recuperer les fichiers dans la table fichiers
    $sql = "SELECT * FROM fichiers";
    $stmt = $pdo->query($sql);
    $fichiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des fichiers</title> 
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/upload.css">   
</head>
<body>
    <header>
        <div class="logo">
            <span class="highlight"><img src="../assets/images/logo-esma.png" alt="Logo ESMA" height="40" width="70"></span>
        </div>
        <div class="user-menu">
            <i class="fa-solid fa-user"></i>  <i class="fa-solid fa-chevron-down" style="font-size: 12px;"></i>
        </div>
    </header>


     <div class="admin-wrapper">
        <aside class="sidebar">
            <ul>
                <li><a href="../admin/upload.php" id="link-upload">Télécharger</a></li>
                <li><a href="../admin/admin_dash.php"id="link-list">Voir tous les fichiers</a></li>
                
            </ul>
        </aside>

         <main class="content">
            <div id="section-list">
                <div class="button-group"></div>
                <h2 class="content-title">Listes des fichiers</h2>
                <table>
                    <thead>
                        <tr>
                            <th width="10%">N</th>
                            <th width="50%">Noms</th>
                            <th width="40%">Actions</th>
                        </tr>
                    </thead>

         <tbody>
             <?php   foreach($fichiers as $fichier){ ?>

                    <tr>
                        <td><?php echo $fichier['id_fichier']; ?></td>
                        <td>  <?php echo $fichier['nom_fichier']; ?></td>
                        <td class="action-cell">
                             <a  class="action-delete" href="../admin/delete.php?id=<?php echo $fichier['id_fichier']; ?>" 
                             onclick="return confirm('Voulez-vous vraiment supprimer ce fichier ?');"
                             >Supprimmer</a> </td>
                    </tr>
                    

              <?php } ?>      
          </tbody>    

         </table>

</div>

          <div id="section-upload" style="display: none;">
                <h2>Telecharger un fichier CSV</h2>
                <form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-form">
                    <label>Choisir un fichier :</label>
                    <input type="file" name="fichier" accept=".csv" required>
                    <br><br>
                    <button type="submit">Telecharger</button>
                    
                    <p class="legal-notice" style="margin-top: 15px; font-size: 12px; color: #666;">
                        * En téléchargeant ce fichier, vous vous engagez à respecter la confidentialité des données à caractère personnel qu'il contient.
                    </p>
                </form>
            </div>

   </main>

</div>
<script>
        // Récupération des éléments du DOM
        const linkUpload = document.getElementById('link-upload');
        const linkList = document.getElementById('link-list');
        const sectionUpload = document.getElementById('section-upload');
        const sectionList = document.getElementById('section-list');

        // Action quand on clique sur "Télécharger" (Upload)
        linkUpload.addEventListener('click', function(e) {
            e.preventDefault(); // Empêche le comportement par défaut du lien
            
            // On cache la liste, on affiche l'upload
            sectionList.style.display = 'none';
            sectionUpload.style.display = 'block';
            
            // Mise à jour de la classe "active" sur le menu
            linkUpload.parentElement.classList.add('active');
            linkList.parentElement.classList.remove('active');
        });

        // Action quand on clique sur "Voir tous les fichiers"
        linkList.addEventListener('click', function(e) {
            e.preventDefault();
            
            // On cache l'upload, on affiche la liste
            sectionUpload.style.display = 'none';
            sectionList.style.display = 'block';
            
            // Mise à jour de la classe "active" sur le menu
            linkList.parentElement.classList.add('active');
            linkUpload.parentElement.classList.remove('active');
        });
    </script>


</body>
</html>