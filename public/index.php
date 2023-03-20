<!DOCTYPE html>
<html>

<head>
  <title>Tirage au sort loterie</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <header>
    <h1>Tirage au sort loterie</h1>
  </header>
  <main>
    <div>
      <h2>Veuillez déposer votre fichier CSV</h2>
      <p>Le contenu de ce fichier doit respecter le format montré ci-dessous.</p>
      <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="csv_file" />
        <input type="submit" />
      </form>

      <h3>Quel est le format à utiliser ?</h3>
      <p>Le fichier CSV doit contenir les données suivantes, dans le même ordre, sans espaces, séparé par des virgules :</p>
      <ul>
        <li>Nom et Prénom du joueur</li>
        <li>Grille de jeu (A, B, C, D, E)</li>
        <li>Numéro 1</li>
        <li>Numéro 2</li>
        <li>Numéro 3</li>
        <li>Numéro 4</li>
        <li>Numéro 5</li>
        <li>Numéro 6</li>
        <li>Numéro 7</li>
        <li>Numéro chance</li>
      </ul>
      <p>Chaque ligne du fichier correspond à un joueur.</p>

      <h3>Exemple de fichier CSV</h3>
      <p>Voici un exemple de fichier CSV :</p>
      <pre>
      <code>
        Nom,Grille,Numero_1,Numero_2,Numero_3,Numero_4,Numero_5,Numero_6,Numero_7,Numero_chance
        DUPONT_Jean,A,1,2,3,4,5,6,7,8
        DUPONT_Jeanne,B,1,2,3,4,5,6,7,8
        DUPONT_Jean,B,1,2,3,4,5,6,7,8
        DUPONT_Jeanne,A,1,2,3,4,5,6,7,8
      </code>
</div>
    </main>
    <footer>
      <p>Créé par <a href="https://www.github.com/GaburaisuVGC/">Matthieu Barbe</a></p>
    </footer>
  </body>
</html>