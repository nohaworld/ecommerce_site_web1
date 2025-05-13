<?php 
session_start();
if(!isset($_SESSION['email']))
  header('location:index.php');


else {?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aseel home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="about.css">
    <style>      .account-dropdown {
  position: absolute;
  top: 60px;
  right: 20px;
  width: 220px;
  background: #fff;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  border-radius: 6px;
  padding: 15px 0;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
  pointer-events: none;
  z-index: 9999;
}

.account-dropdown.show {
  opacity: 1;
  visibility: visible;
  pointer-events: auto;
}

.account-dropdown h4 {
  margin: 0;
  padding: 10px 20px;
  font-size: 12px;
  font-weight: bold;
  color: #333;
  border-top: 1px solid #eee;
}

.account-dropdown h4:first-child {
  border-top: none;
}

.account-dropdown a {
  display: block;
  padding: 8px 20px;
  font-size: 14px;
  color: #444;
  text-decoration: none;
}

.account-dropdown a:hover {
  background-color: #f5f5f5;
}

.custom-dropdown {
  position: relative;
  display: inline-block;
  width: 250px;
}

     
        .custom-dropdown {
          position: relative;
          display: inline-block;
          width: 250px;
        }
    
        select {
          width: 70%;
          padding: 10px 16px;
          font-size: 16px;
          background-color: transparent;
          appearance: none;  /* Masquer la flèche native */
          -webkit-appearance: none; /* Masquer la flèche sur Safari */
          -moz-appearance: none; /* Masquer la flèche sur Firefox */
          border: none;  /* Supprimer la bordure */
          outline: none;  /* Supprimer le contour */
          color: #333;
          padding-right: 30px; /* Ajouter de l'espace pour l'icône */
        }
    
        /* Style pour l'icône caret */
        .dropdown-icon {
          position: absolute;
          right: 10px;
          top: 50%;
          transform: translateY(-50%);
          font-size: 16px;
          color: #333;
          pointer-events: none;
        }
    
        option {
          padding: 8px;
        }
    
        option:hover {
          background-color: #eaeaea;
        }
      </style>
</head>
<body>

    <header>
        <a href="# " class="logo">assel</a>
    
        <ul class="navmenu">
            <li><a  href="index.php">home</a></li>
          
            <li><a  href="shop.php">shop</a></li>
            <li><a class="active" href="about.php">about </a></li> 
            <li><a href="connexion.php">login</a></li>
        </ul>
       
        <div class="nav-icon">
           <!-- <div class="custom-dropdown">
                <select id="product-select">
                <option value="copilot">WOMEN</option>
                  <option value="security">MEN</option>
                  <option value="actions">KIDS</option>
                  <option value="codespaces">WEDDING</option>
                  <option value="issues">CLASSIQUE</option>

                  </option>
                </select>
            
                <i class="fa fa-caret-down" ></i>
              </div>
        
             
                <a href ="#"><button class="btn" onclick="document.getElementById('id01').style.display='block'"><i class="fa fa-search" aria-hidden="true"></i></button> </a>
                <div class="search">
                    <input id="id01" class="srch" type="search" placeholder="type to text" >
                     <script>
                document.getElementById('id01').style.display='none';
             </script>
            </div> -->
        <li><a href="#"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></li> 
        <li><a href="#"><i class="fa fa-user-circle-o" id="accountIcon" aria-hidden="true"></i></a></li>
        <li>
  <div class="account-dropdown" id="accountDropdown">
    <h4>MON COMPTE</h4>
    <a href="profile.php">Mon Profil</a>
    <a href="mes_commandes.php">Mes Commandes</a>
 

    <h4>AIDE</h4>
    <a href="suivic.php">Suivi de Commande</a>
    <a href="contact.php">Contact & Support</a>
    <a href="about.php">FAQ</a>

    <h4>AUTHENTIFICATION</h4>
    <a href="connexion.php">Connexion</a>
    <a href="signup.php">Créer un Compte</a>
        <h4>DECONNECTER</h4>
    <a href="deconnexion.php">Deconnexion</a>
  </div>
</li>
        
        </div>
    </header> 
 <div class="main">
    <div class="content">
        <div class="about-container">
            <h1>À propos de Aseel Shop</h1>
            <p>
                Bienvenue chez <strong>Aseel Shop</strong> ! 💍<br><br>
                Nous sommes une boutique en ligne spécialisée dans les bagues en or raffinées, conçues pour allier élégance et authenticité.
            </p>
            <p>
                Chaque pièce de notre collection est soigneusement sélectionnée pour offrir le meilleur de la qualité et du design à notre clientèle.
            </p>
            <p>
                Que ce soit pour offrir ou pour se faire plaisir, nos bijoux sauront sublimer chaque moment précieux de votre vie.
            </p>
            <p>
                Merci de faire confiance à Aseel Shop. Votre satisfaction est notre priorité !
            </p>
        </div>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const accountIcon = document.getElementById('accountIcon');
    const dropdown = document.getElementById('accountDropdown');

    // Ouvrir/fermer le menu au clic sur l'icône de compte
    accountIcon.addEventListener('click', (e) => {
        e.stopPropagation();  // Empêche la propagation du clic sur l'icône
        dropdown.classList.toggle('show');
    });

    // Fermer le menu si on clique à l'extérieur
    window.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target) && !accountIcon.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });

    // Empêche le menu de se fermer quand on clique dedans
    dropdown.addEventListener('click', (e) => {
        e.stopPropagation();
    });
});
</script>
     
</body>
</html>
<?php 
}?>