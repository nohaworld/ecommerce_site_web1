<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

include 'admin/connexion.php';


// Traitement du formulaire de mise à jour
if (isset($_POST['submit'])) {
    $nom = $_POST['nom'];

    $email = $_POST['email'];
    $mot_de_passe = !empty($_POST['mot_de_passe']) ? password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT) : null;

    $query = "UPDATE utilisateurs SET nom = :nom, email = :email";
    if ($mot_de_passe) {
        $query .= ", mot_de_passe = :mot_de_passe";
    }
    $query .= " WHERE id = :id";

    $stmt = $pdo->prepare($query);
    $params = [
        'nom' => $nom,
        
        'email' => $email,
        'id' => $_SESSION['user_id']
    ];
    if ($mot_de_passe) {
        $params['mot_de_passe'] = $mot_de_passe;
    }
    $stmt->execute($params);

    // Met à jour les valeurs de session

    $_SESSION['user_name'] = $nom;
    $_SESSION['email'] = $email;

    $success = "Informations mises à jour avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Profil - Boutique de Bagues</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    h1 {
      margin-top: 0;
      color: #444;
    }

    .info {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-top: 10px;
      color: #666;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      margin-top: 20px;
      background-color: #c89b3f;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #a57e30;
    }

    .success {
      color: green;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Mon Profil</h1>

    <?php if (isset($success)): ?>
      <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form action="" method="POST">
     
      <div class="info">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($_SESSION['user_name']) ?>" >
      </div>

      <div class="info">
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_SESSION['email']) ?>">
      </div>

      <div class="info">
        <label for="mot_de_passe">Mot de passe </label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required value="<?= htmlspecialchars($_SESSION['mot_de_passe']) ?>">
      </div>

      <button type="submit" name="submit">Mettre à jour</button>
    </form>
  </div>

</body>
</html>
