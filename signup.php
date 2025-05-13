<?php
include 'admin/connexion.php';  // Assurez-vous que le chemin vers connexion.php est correct

// Traitement du formulaire
if (isset($_POST['submit'])) {
    if (isset($_POST['nom'], $_POST['email'], $_POST['password'], $_POST['confirm_password'])) {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordc = $_POST['confirm_password'];

        // Valider l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "L'adresse email n'est pas valide.";
        } else {
            // Vérification si l'email existe déjà
            $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                $message = "Un compte existe déjà avec cette adresse email.";
            } else {
                // Vérification de la correspondance des mots de passe
                if ($password == $passwordc) {
                    // Insertion du nouvel utilisateur
                    $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, mot_de_passe, nom) VALUES (:email, :mot_de_passe, :nom)");
                    $stmt->execute(['email' => $email, 'mot_de_passe' => password_hash($password, PASSWORD_BCRYPT), 'nom' => $nom]);
                    $message = "Votre compte a bien été créé.";
                } else {
                    $message = "Les mots de passe ne correspondent pas.";
                }
            }
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Aseel Shop</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="signup-container">
        <h1>Créer un compte</h1>
        <!-- Afficher le message d'erreur ou de succès -->
        <?php if (isset($message)) : ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="" method="post">
            <input type="text" name="nom" placeholder="Nom complet" required>
            <input type="email" name="email" placeholder="Adresse email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <button type="submit" name="submit">S'inscrire</button>
        </form>
        <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
    </div>
</body>
</html>
