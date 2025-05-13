<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a name="commandes"></a>
<section>
  <h2>📦 Commandes</h2>

  <form method="post">
    <input type="text" name="id" placeholder="ID (modif/supp)" />
    <input type="text" name="utilisateur_id" placeholder="ID Utilisateur" required /><br>
    <select name="statut">
      <option value="en_attente">En attente</option>
      <option value="en_cours">En cours</option>
      <option value="livree">Livrée</option>
      <option value="annulee">Annulée</option>
    </select><br>
    
    <button name="ajouter_commande">Ajouter</button>
    <button name="modifier_commande">Modifier</button>
    <button name="supprimer_commande">Supprimer</button>
  </form>

<?php
include 'connexion.php';
if (isset($_POST['ajouter_commande'])) {
  $sql = "INSERT INTO commandes (utilisateur_id, statut) VALUES (?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['utilisateur_id'], $_POST['statut']]);
  echo "<p>✅ Commande ajoutée</p>";
}

// MODIF
if (isset($_POST['modifier_commande'])) {
  $sql = "UPDATE commandes SET utilisateur_id=?, statut=? WHERE id=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['utilisateur_id'], $_POST['statut'], $_POST['id']]);
  echo "<p>✏️ Commande modifiée</p>";
}

// SUPPR
if (isset($_POST['supprimer_commande'])) {
  $sql = "DELETE FROM commandes WHERE id=?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$_POST['id']]);
  echo "<p>🗑️ Commande supprimée</p>";
}

// AFFICHAGE
$stmt = $pdo->query("SELECT * FROM commandes");
echo "<table><tr><th>ID</th><th>Utilisateur ID</th><th>Date</th><th>Statut</th></tr>";
while ($row = $stmt->fetch()) {
  echo "<tr><td>{$row['id']}</td><td>{$row['utilisateur_id']}</td><td>{$row['date_commande']}</td><td>{$row['statut']}</td></tr>";
}
echo "</table>";
?>
</section>

</body>
</html>