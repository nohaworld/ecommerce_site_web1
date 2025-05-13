<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a name="lignes_commandes"></a>
<section>
  <h2>🧾 Lignes de Commandes</h2>

  <form method="post">
    <input type="text" name="id" placeholder="ID (modif/supp)" />
    <input type="text" name="commande_id" placeholder="ID Commande" required /><br>
    <input type="text" name="produit_id" placeholder="ID Produit" required /><br>
    <input type="number" name="quantite" placeholder="Quantité" min="1" required /><br>
    <input type="text" name="prix_unitaire" placeholder="Prix Unitaire" required /><br>

    <button name="ajouter_ligne">Ajouter</button>
    <button name="modifier_ligne">Modifier</button>
    <button name="supprimer_ligne">Supprimer</button>
  </form>

<?php
include 'connexion.php';
if (isset($_POST['ajouter_ligne'])) {
  $sql = "INSERT INTO lignes_commandes (commande_id, produit_id, quantite, prix_unitaire) 
          VALUES (?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['commande_id'], $_POST['produit_id'], $_POST['quantite'], $_POST['prix_unitaire']]);
  echo "<p>✅ Ligne de commande ajoutée</p>";
}

// MODIF
if (isset($_POST['modifier_ligne'])) {
  $sql = "UPDATE lignes_commandes 
          SET commande_id=?, produit_id=?, quantite=?, prix_unitaire=? 
          WHERE id=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $_POST['commande_id'], 
    $_POST['produit_id'], 
    $_POST['quantite'], 
    $_POST['prix_unitaire'], 
    $_POST['id']
  ]);
  echo "<p>✏️ Ligne de commande modifiée</p>";
}

// SUPPR
if (isset($_POST['supprimer_ligne'])) {
  $sql = "DELETE FROM lignes_commandes WHERE id=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['id']]);
  echo "<p>🗑️ Ligne supprimée</p>";
}

// AFFICHAGE
$stmt = $pdo->query("SELECT * FROM lignes_commandes");
echo "<table><tr><th>ID</th><th>Commande ID</th><th>Produit ID</th><th>Quantité</th><th>Prix Unitaire</th></tr>";
while ($row = $stmt->fetch()) {
  echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['commande_id']}</td>
          <td>{$row['produit_id']}</td>
          <td>{$row['quantite']}</td>
          <td>{$row['prix_unitaire']}</td>
        </tr>";
}
echo "</table>";
?>
</section>

</body>
</html>