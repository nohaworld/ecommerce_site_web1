
<?php
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
   
}else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Aseel Shop</title>
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
   

        <div class="contact-container">
            <h1>Contactez-nous</h1>
            <form action="#" method="post">
                <input type="text" name="name" placeholder="Votre nom" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <textarea name="message" rows="5" placeholder="Votre message..." required></textarea>
                <button type="submit">Envoyer</button>
            </form>

            <div class="contact-infos">
                <p><i class="fas fa-envelope"></i> contact@aseelshop.com</p>
                <p><i class="fas fa-phone"></i> +212 613 456 789</p>
                <p><i class="fas fa-map-marker-alt"></i> Rabat, Maroc</p>
            </div>
        </div>
  
</body>
</html>
<?php }?>