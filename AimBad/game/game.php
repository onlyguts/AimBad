<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <link href="game.css" rel="stylesheet" >
    <link href="../css/logo.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Aimbad - In Game</title>
  </head>
  <body>
    <div class="logo-container">
      <a href="../index.php" class="lien-icone">
        <img src="../asset/img/logo.png" alt="" class="logo">
        <h1>AimBad</h1>
      </a>
    </div>
    <div class="container">
      <div id="score-container">
        Score: <span id="score">0</span><br>
        Temps: <span id="timer">10:000</span><br>
        <button id="menu-retry">Rejouer</button><br>
      </div>
    </div>

    <div id="cercles-container">
      <!-- Le reste du contenu de la page -->
    </div>
    <p id="game-over-message" class="hidden">END</p>
    <script src="app.js"></script>
  </body>
</html>