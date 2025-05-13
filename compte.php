<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Profil Utilisateur</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .account-icon {
      position: fixed;
      top: 20px;
      right: 20px;
      font-size: 30px;
      cursor: pointer;
    }

    /* Fond sombre derrière la pop-up */
    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }

    /* Fenêtre modale centrée */
    .popup {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      display: none;
      z-index: 1000;
    }

    .popup h2 {
      margin-top: 0;
    }

    .popup label {
      display: block;
      margin: 10px 0 5px;
    }

    .popup input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .popup .actions {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;
    }

    .popup button {
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-close {
      background: #ccc;
    }

    .btn-edit {
      background: #007bff;
      color: #fff;
    }

    .btn-edit:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

<!-- Icône utilisateur -->
<div class="account-icon" id="accountIcon">👤</div>

<!-- Overlay et fenêtre d'info -->
<div class="overlay" id="overlay"></div>

<div class="popup" id="popup">
  <h2>Informations du Compte</h2>
  <label for="name">Nom :</label>
  <input type="text" id="name" value="Jean Dupont">

  <label for="email">Email :</label>
  <input type="email" id="email" value="jean.dupont@example.com">

  <div class="actions">
    <button class="btn-close" id="closePopup">Fermer</button>
    <button class="btn-edit">Modifier</button>
  </div>
</div>

<script>
  const icon = document.getElementById('accountIcon');
  const popup = document.getElementById('popup');
  const overlay = document.getElementById('overlay');
  const closePopup = document.getElementById('closePopup');

  icon.addEventListener('click', () => {
    popup.style.display = 'block';
    overlay.style.display = 'block';
  });

  closePopup.addEventListener('click', () => {
    popup.style.display = 'none';
    overlay.style.display = 'none';
  });

  overlay.addEventListener('click', () => {
    popup.style.display = 'none';
    overlay.style.display = 'none';
  });
</script>

</body>
</html>
