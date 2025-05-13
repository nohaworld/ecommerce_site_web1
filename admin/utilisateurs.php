<?php include("connexion.php"); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
    <style>
        input, select { margin-bottom: 5px; width: 300px; padding: 5px; }
        table { margin-top: 20px; border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    </style>
</head>
<body>

<h2>🧑‍💼 Gestion des utilisateurs</h2>

<form method="post">
    <input type="hidden" name="id" value="">
    <label>Nom :</label><br>
    <input type="text" name="nom" required><br>
    
    <label>Email :</label><br>
    <input type="email" name="email" required><br>
    
    <label>Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br>
    
    <label>Rôle :</label><br>
    <select name="role">
        <option value="client">Client</option>
        <option value="administrateur">Administrateur</option>
    </select><br><br>

    <button type="submit" name="ajouter">Ajouter</button>
    <button type="submit" name="modifier">Modifier</button>
    <button type="submit" name="supprimer">Supprimer</button>
</form>

<?php
// Connexion à la BDD
$pdo = new PDO("mysql:host=localhost;dbname=boutique_en_ligne", "root", "");

// AJOUTER
if (isset($_POST['ajouter'])) {
    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['nom'], $_POST['email'], password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT), $_POST['role']]);
    echo "<p>✅ Utilisateur ajouté.</p>";
}

// MODIFIER
if (isset($_POST['modifier'])) {
    $sql = "UPDATE utilisateurs SET nom=?, email=?, role=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['nom'], $_POST['email'], $_POST['role'], $_POST['id']]);
    echo "<p>✏️ Utilisateur modifié.</p>";
}

// SUPPRIMER
if (isset($_POST['supprimer'])) {
    $sql = "DELETE FROM utilisateurs WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['id']]);
    echo "<p>🗑️ Utilisateur supprimé.</p>";
}

// AFFICHAGE
$stmt = $pdo->query("SELECT * FROM utilisateurs");
echo "<h3>📋 Liste des utilisateurs</h3>";
echo "<table><tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th></tr>";
while ($row = $stmt->fetch()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nom']}</td>
        <td>{$row['email']}</td>
        <td>{$row['role']}</td>
    </tr>";
}
echo "</table>";
?>

</body>
</html>
