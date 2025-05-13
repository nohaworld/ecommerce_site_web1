<?php 
  session_start();
   include_once "con_dbb.php";

   //supprimer les produits
   //si la variable del existe
   if(isset($_GET['del'])){
    $id_del = $_GET['del'] ;
    //suppression
    unset($_SESSION['panier'][$id_del]);
   }


   if (isset($_POST['id'], $_POST['quantite'])) {
    $id = intval($_POST['id']);
    $quantite = intval($_POST['quantite']);

    if ($quantite > 0 && isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id] = $quantite;
    }
}
/*session_start();
include_once "con_dbb.php";

// Supprimer un produit
if (isset($_GET['del']) && is_numeric($_GET['del'])) {
    $id_del = $_GET['del'];
    unset($_SESSION['panier'][$id_del]);
}*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body class="panier">
    <a href="index.php" class="link">Boutique</a>
   
    <section>
        <table>
            <tr>
                <th></th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
            <?php 
              $total = 0 ;
              if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = []; // initialise un panier vide si inexistant
}
              // liste des produits
              //récupérer les clés du tableau session
              $ids = array_keys($_SESSION['panier']);
              //s'il n'y a aucune clé dans le tableau
              if(empty($ids)){
                echo "Votre panier est vide";
              }else {
                //si oui 
                $products = mysqli_query($con, "SELECT * FROM produits WHERE id IN (".implode(',', $ids).")");

                //lise des produit avec une boucle foreach
                foreach($products as $product):
                    //calculer le total ( prix unitaire * quantité) 
                    //et aditionner chaque résutats a chaque tour de boucle
                    $total = $total + $product['prix'] * $_SESSION['panier'][$product['id']] ;
                ?>
                <tr>
                    <td><img src="<?=$product['image']?>"></td>
                    <td><?=$product['nom']?></td>
                    <td><?=$product['prix']?>€</td>
                   <td>
                     <form method="post" action="">
        <input type="hidden" name="id" value="<?=$product['id']?>">
        <input type="number" name="quantite" value="<?=$_SESSION['panier'][$product['id']]?>" min="1" style="width:37px;">
        <button type="submit" style=" background-color: #a6692bc9; color:white;  border-radius: 3px; border:none;">OK</button>
                  </form>
              </td>
                    <td><a href="cart.php?del=<?=$product['id']?>"><img src="delete.png"></a></td>
                </tr>

            <?php endforeach ;} ?>

            <tr class="total">
                <th>Total : <?=$total?>€</th>

            </tr>


            
        </table>
    </section>
    <a href="checkout.php" class="link">Boutique</a>
</body>