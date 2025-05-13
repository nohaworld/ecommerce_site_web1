<?php include("connexion.php"); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Admin - Produits</title>
  <link rel="stylesheet" href="style.css">
  <style>
    
    input, textarea { margin-bottom: 5px; width: 300px; padding: 5px; }
    table { margin-top: 20px; border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
  </style>
</head>
<body>
<h2>📦 Gestion des produits</h2>

<form method="post">
  <input type="text" name="id" placeholder="ID du produit (pour modifier ou supprimer)"><br>
  <input type="text" name="nom" placeholder="Nom" ><br>
  <textarea name="description" placeholder="Description"></textarea><br>
  <input type="number" step="0.01" name="prix" placeholder="Prix" ><br>
  <input type="text" name="categorie" placeholder="Catégorie"><br>
  <input type="text" name="image" placeholder="Nom du fichier image"><br><br>
  
  <button name="ajouter">Ajouter</button>
  <button name="modifier">Modifier</button>
  <button name="supprimer">Supprimer</button>
</form>

<?php
include 'connexion.php';
$pdo = new PDO("mysql:host=localhost;dbname=boutique_en_ligne", "root", "");

// AJOUT
if (isset($_POST['ajouter'])) {
  $sql = "INSERT INTO produits (nom, description, prix, categorie, image) VALUES (?, ?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['categorie'], $_POST['image']]);
  echo "<p>✅ Produit ajouté.</p>";
}

// MODIFICATION
if (isset($_POST['modifier'])) {
  $sql = "UPDATE produits SET nom=?, description=?, prix=?, categorie=?, image=? WHERE id=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['nom'], $_POST['description'], $_POST['prix'], $_POST['categorie'], $_POST['image'], $_POST['id']]);
  echo "<p>✏️ Produit modifié.</p>";
}

// SUPPRESSION
if (isset($_POST['supprimer'])) {
  $sql = "DELETE FROM produits WHERE id=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['id']]);
  echo "<p>🗑️ Produit supprimé.</p>";
}

// AFFICHAGE
$stmt = $pdo->query("SELECT * FROM produits");
echo "<h3>📋 Liste des produits</h3>";
echo "<table><tr><th>ID</th><th>Nom</th><th>Description</th><th>Prix</th><th>Catégorie</th><th>Image</th></tr>";
while ($row = $stmt->fetch()) {
  echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['nom']}</td>
    <td>{$row['description']}</td>
    <td>{$row['prix']}</td>
    <td>{$row['categorie']}</td>
    <td>   <img src='" . htmlspecialchars($row['image']) . "' alt='Produit image' style='width:100px; height:100px;'></td>
  </tr>";
}
echo "</table>";
?>
</body>
</html>
