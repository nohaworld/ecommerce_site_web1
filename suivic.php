<?php
session_start();
include 'admin/connexion.php';
$error = '';

if (!isset($_SESSION['email'])) {
    $error = 'Il faut se connecter d\'abord';
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check'])) {
        $orderNumber = $_POST['orderNumber'];

        // Vérifier si le numéro de commande n'est pas vide et est un nombre entier
        if (empty($orderNumber) || !is_numeric($orderNumber)) {
            $error = 'Le numéro de commande est invalide.';
        } else {
            // Préparer la requête pour récupérer la commande
            $stmt = $pdo->prepare("SELECT * FROM commandes WHERE utilisateur_id = :id AND id = :orderNumber");
            $stmt->execute(['id' => $_SESSION['user_id'], 'orderNumber' => $orderNumber]);
            $commande = $stmt->fetch();

            if ($commande) {
                $_SESSION['date_commande'] = $commande['date_commande'];
                $_SESSION['statut'] = $commande['statut'];
            } else {
                $error = 'Commande non trouvée.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Suivi de Commande - Boutique de Bagues</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      padding: 30px;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #333;
    }

    .error {
      color: red;
      margin-bottom: 15px;
      text-align: center;
    }

    form {
      margin-top: 30px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #555;
    }

    input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    button {
      width: 100%;
      background-color:  #8B4513;
      color: white;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #8B4513;
    }

    .result {
      margin-top: 20px;
      background-color: #f6f6f6;
      border-left: 4px solid  #8B4513;
      padding: 15px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Suivi de Commande</h1>

    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
      <label for="orderNumber">Numéro de commande</label>
      <input type="text" name="orderNumber" placeholder="Ex: CMD123456" required>
      <button type="submit" name="check">Vérifier le statut</button>
    </form>

    <?php if (isset($_SESSION['statut']) && isset($_SESSION['date_commande'])): ?>
      <div class="result">
        <strong>Statut :</strong> <?php echo $_SESSION['statut']; ?><br>
        <strong>Date estimée de livraison :</strong> <?php echo $_SESSION['date_commande'];?><br>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>
