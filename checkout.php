<?php
// checkout.php (Page de commande et traitement)

session_start();
$mysqli = new mysqli("localhost", "root", "", "boutique_en_ligne");

if (isset($_POST['place_order'])) {
    if (isset($_SESSION['user_id'])) {
        $utilisateur_id = $_SESSION['user_id'];
        $panier = $_SESSION['panier'] ?? [];

        if (empty($panier)) {
            header("Location: cart.php");
            exit;
        }

        // Créer la commande avec date et statut
        $date_commande = date('Y-m-d H:i:s');
        $statut = 'en_attente';

        $stmt = $mysqli->prepare("INSERT INTO commandes (utilisateur_id, date_commande, statut) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $utilisateur_id, $date_commande, $statut);
        $stmt->execute();
        $commande_id = $stmt->insert_id;
        $stmt->close();

        // Ajouter les lignes de commande
        foreach ($panier as $produit_id => $quantite) {
            $stmt = $mysqli->prepare("SELECT prix FROM produits WHERE id = ?");
            $stmt->bind_param("i", $produit_id);
            $stmt->execute();
            $stmt->bind_result($prix);
            $stmt->fetch();
            $stmt->close();

            $stmt = $mysqli->prepare("INSERT INTO lignes_commandes (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $commande_id, $produit_id, $quantite, $prix);
            $stmt->execute();
            $stmt->close();
        }

        // Vider le panier
        unset($_SESSION['panier']);

        
    } else {
        header("Location: connexion.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html> 
    
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
   <link rel="stylesheet" href="chekout.css">
</head>
<body>
 <div class="checkout">
       <div class="heading">
             <h2 style="color: #8B4513; font-size: 28px; font-weight: bold; text-align: center; text-transform: uppercase; letter-spacing: 1px;"><?php if (isset($commande_id)) echo 'Numéro de commande : ' . $commande_id; ?></h2>

       </div>
       <div class="row">
        <form action="" method="post" class="registre" >
          <input type="hidden" name="p_id" value="">
           <h3><i>billing details</i></h3>
           <div class="flex">
             <div class="box">
                <div class="input_field">
                    <p>your name </p>
                    <input type="text" name="name" required maxlength="50" placeholder="Enter your name" class="input">
                </div>
                <div class="input_field">
                    <p>your number </p>
                    <input type="text" name="number" required maxlength="10" placeholder="Enter your number" class="input">
                </div>
                <div class="input_field">
                    <p>your email </p>
                    <input type="email" name="email" required maxlength="50" placeholder="Enter your email" class="input">
                </div>
                <div class="input_field">
                    <p>your method </p>
                   <select name="method" class="input">
                    <option value="cash on delivery">cash on delivery</option>
                    <option value="credit  or debit card">credit  or debit card</option>
                     <option value="net banking">net banking</option>
                    <option value="paytm">paytm</option>
                   </select>
                </div>
               
             </div>
             <div class="box">
                <div class="input_field">
                    <p>address line 01</p>
                    <input type="text" name="flat" required maxlength="50" placeholder="building name" class="input">
                </div>
                
                <div class="input_field">
                    <p>city name</p>
                    <input type="text" name="city" required maxlength="50" placeholder="city name" class="input">
                </div>
                <div class="input_field">
                    <p>country name</p>
                    <input type="text" name="country" required maxlength="50" placeholder="country name" class="input">
                </div>
                <div class="input_field">
                    <p>pincode</p>
                    <input type="text" name="pin" required maxlength="6" placeholder="pincode" class="input">
                </div>
             </div>
           </div>
           <button type="submit" name="place_order" class="btn">place order</button>

      

        </form>

       </div>




 </div>
 









</body>
<html>