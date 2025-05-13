<?php
session_start();
require_once 'admin/connexion.php'; // Assure-toi d'inclure correctement ton fichier de connexion

if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // Redirection si l'utilisateur n'est pas connecté
    exit();
}

$id_client = $_SESSION['user_id']; // Récupérer l'ID de l'utilisateur depuis la session

// Récupérer les commandes de l'utilisateur
$sql = "SELECT c.id AS commande_id, c.date_commande, c.statut, 
               lc.prix_unitaire, lc.quantite, 
               (lc.prix_unitaire * lc.quantite) AS total,  -- Calcul du total
               p.nom AS produit_nom, p.image AS produit_image
        FROM commandes c
        JOIN lignes_commandes lc ON lc.commande_id = c.id
        JOIN produits p ON lc.produit_id = p.id
        WHERE c.utilisateur_id = :id_client
        ORDER BY c.date_commande DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id_client' => $id_client]);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mes Commandes</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f5f5;
      padding: 30px;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #8B4513;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 12px;
      text-align: center;
    }
    th {
      background-color: #8B4513;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    img {
      width: 50px; /* Taille de l'image */
      height: auto;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Mes Commandes</h1>

    <?php if (count($commandes) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Date de Commande</th>
          <th>Statut</th>
          <th>Produit</th>
          <th>Image</th>
          <th>Prix Unitaire</th>
          <th>Quantité</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($commandes as $commande): ?>
        <tr>
          <td><?= $commande['commande_id'] ?></td>
          <td><?= $commande['date_commande'] ?></td>
          <td><?= htmlspecialchars($commande['statut']) ?></td>
          <td><?= htmlspecialchars($commande['produit_nom']) ?></td>
          <td>
            <?php if ($commande['produit_image']): ?>
              <img src="<?= htmlspecialchars($commande['produit_image']) ?>" alt="<?= htmlspecialchars($commande['produit_nom']) ?>">
            <?php else: ?>
              <p>Aucune image</p>
            <?php endif; ?>
          </td>
          <td><?= number_format($commande['prix_unitaire'], 2) ?> €</td>
          <td><?= $commande['quantite'] ?></td>
          <td><?= number_format($commande['total'], 2) ?> €</td> <!-- Affichage du total calculé -->
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <p style="text-align:center; color:#888;">Aucune commande trouvée.</p>
    <?php endif; ?>
  </div>

</body>
</html>
