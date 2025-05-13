<?php
session_start();
$conn = new mysqli("localhost", "root", "", "boutique_en_ligne");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Valeur par défaut


// Si une catégorie est choisie via formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['categorie'])) {
    $filtre = $_POST['categorie'];
    $stmt = $conn->prepare("SELECT * FROM produits WHERE categorie = ?");
    $stmt->bind_param("s", $filtre);
    if ($filtre == 'all'){
    $stmt = $conn->prepare("SELECT * FROM produits ");
    }


}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['bar']) ) {
  
    $filtre1 = floatval($_POST['bar']); // Assurer que c’est un float

    // Préparation de la requête de filtrage
    $stmt = $conn->prepare("SELECT * FROM produits WHERE prix < ? ORDER BY prix ASC");
    $stmt->bind_param("d", $filtre1); // 'd' pour double (float), 

   
}

if(empty($_POST['categorie']) && empty($_POST['bar']) ){

// Préparation de la requête
$stmt = $conn->prepare("SELECT * FROM produits ");
}


$stmt->execute();
$result = $stmt->get_result();
$produits = [];

while ($row = $result->fetch_assoc()) {
    $produits[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aseel home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="shop.css">
    <!-- Ton CSS ici (déjà fourni, tu peux garder ou alléger selon ton besoin) -->
    <style>
            .account-dropdown {
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
  z-index: 101111111110;
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
    
        select {
          appearance: none;
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
        /* Style de l'icône du panier */

        .cart-container {
            position: relative;
            display: inline-block;
            margin-right: 20px; /* Espace entre l'icône et les autres éléments */
        }

        /* Badge du nombre d'articles */
        #cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Style de l'icône */
        #cartIcon {
            font-size: 24px;
            color: #333;
        }

        /* Menu déroulant du panier */
        .cart-dropdown {
            position: absolute;
            top: 60px; /* Positionné en dessous de l'icône */
            right: 0;
            width: 220px;
            background: #fff;
            box-shadow: 0 2px 10px rgb(80, 68, 45);
            border-radius: 6px;
            padding: 15px 0;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
            pointer-events: none;
            z-index: 100;
        }

        .cart-dropdown.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .cart-dropdown h4 {
            margin: 0;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            color: #333;
            border-top: 1px solid #eee;
        }

        .cart-dropdown a {
            display: block;
            padding: 8px 20px;
            font-size: 14px;
            color: #444;
            text-decoration: none;
        }

        .cart-dropdown a:hover {
            background-color: #f5f5f5;
        }
        #product1 .pro img{
    width: 300px;
    height:330px;
    border-radius: 20px;

    
    
  }
    </style>
</head>
<body>

<header>
    <a href="#" class="logo">assel</a>
    <ul class="navmenu">
        <li><a href="index.php">home</a></li>
        <li><a class="active" href="shop.php">shop</a></li>
        <li><a href="about.php">about</a></li>
        <li><a href="connexion.php">login</a></li>
    </ul>

    <div class="nav-icon">
        <!-- Menu déroulant des catégories -->
        <div class="custom-dropdown">
            <form method="post" action="">
                <select name="categorie" onchange="this.form.submit()" value="catego">
                  <option value="all" <?= (isset($filtre) && $filtre == 'all') ? 'selected' : '' ?> >all</option>
                   <option value="women" <?= (isset($filtre) && $filtre == 'women') ? 'selected' : '' ?>>WOMEN</option>
                    <option value="men" <?= (isset($filtre) && $filtre == 'men') ? 'selected' : '' ?>>MEN</option>
                    <option value="kids" <?=(isset($filtre) && $filtre ==  'kids') ? 'selected' : '' ?>>KIDS</option>
                    <option value="wedding" <?= (isset($filtre) && $filtre ==  'wedding') ? 'selected' : '' ?>>WEDDING</option>
                </select>
            </form>
            <i class="fa fa-caret-down dropdown-icon"></i>
        </div>

        <!-- Recherche -->
        
        <a href="#"><button class="btn" onclick="document.getElementById('id01').style.display='block'"><i class="fa fa-search" aria-hidden="true"></i></button></a>
        <div class="search"> <form action=""  method="post">
            <input id="id01" class="srch" type="search" placeholder="type to text" name="bar">
          </form>  <script>
                document.getElementById('id01').style.display = 'none';
            </script>
        </div>

        <!-- Panier -->
        <li><a href="#"><i class="fa fa-shopping-basket" id="cartIcon" aria-hidden="true"></i></a></li>
        <div class="cart-dropdown" id="cartDropdown">
            <h4>MON PANIER</h4>
            <div id="cart-items">
             
            </div>
            <a href="cart.php">Voir le panier</a>
            <a href="checkout.php">Passer à la caisse</a>
        </div>

        <!-- Compte -->
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

<!-- Affichage des produits -->
<section id="product1" class="section-1">
    <div class="pro1">
     

        <?php foreach ($produits as $row){ ?>
            <div class="pro">
            <img src="<?=$row['image'] ?>">
                <div class="disc">
                    <span><i><?= $row['nom'] ?></i></span>
                    <h5><i><?= $row['description'] ?></i></h5>
                    <h4><i><?= $row['prix'] ?> DH</i></h4>
                    
                  
                </div>
                <button><a href="ajouter_panier.php?id=<?= $row['id'] ?>" class="cart">+</a></button>
           
            </div>
        <?php }; ?> 
        <?php

?>

    </div>
</section>

<!-- Scripts JS (dropdowns) -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const accountIcon = document.getElementById('accountIcon');
        const accountDropdown = document.getElementById('accountDropdown');
        const cartIcon = document.getElementById('cartIcon');
        const cartDropdown = document.getElementById('cartDropdown');

        accountIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            accountDropdown.classList.toggle('show');
        });

        cartIcon.addEventListener('click', (e) => {
            e.stopPropagation();
            cartDropdown.classList.toggle('show');
        });

        window.addEventListener('click', (e) => {
            if (!accountDropdown.contains(e.target) && !accountIcon.contains(e.target)) {
                accountDropdown.classList.remove('show');
            }
            if (!cartDropdown.contains(e.target) && !cartIcon.contains(e.target)) {
                cartDropdown.classList.remove('show');
            }
        });

        accountDropdown.addEventListener('click', (e) => e.stopPropagation());
        cartDropdown.addEventListener('click', (e) => e.stopPropagation());
    });
</script>

</body>
</html>
  