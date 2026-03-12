<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>B2 Collab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background:#f5f6fa;
        }

        header{
            background:#1e293b;
            color:white;
            padding:20px;
        }

        nav{
            display:flex;
            justify-content:space-between;
            align-items:center;
            max-width:1100px;
            margin:auto;
        }

        nav a{
            color:white;
            text-decoration:none;
            margin-left:20px;
            font-weight:500;
        }

        .hero{
            max-width:1100px;
            margin:80px auto;
            text-align:center;
        }

        .hero h1{
            font-size:42px;
            margin-bottom:20px;
        }

        .hero p{
            font-size:18px;
            color:#555;
            margin-bottom:40px;
        }

        .btn{
            background:#2563eb;
            color:white;
            padding:12px 25px;
            text-decoration:none;
            border-radius:6px;
            font-weight:bold;
        }

        .features{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:30px;
            max-width:1100px;
            margin:60px auto;
        }

        .card{
            background:white;
            padding:30px;
            border-radius:8px;
            box-shadow:0 5px 15px rgba(0,0,0,0.05);
        }

        footer{
            text-align:center;
            padding:30px;
            margin-top:60px;
            background:#1e293b;
            color:white;
        }
    </style>
</head>

<body>

<header>
    <nav>
        <h2>B2 Collab</h2>
        <div>
            <a href="/">Accueil</a>
            <a href="/resources">Ressources</a>
            <a href="/login">Connexion</a>
        </div>
    </nav>
</header>

<section class="hero">
    <h1>Plateforme de ressources relationnelles</h1>
    <p>
        Découvrez des ressources pour améliorer les relations humaines :
        famille, travail, couple et amitié.
    </p>

    <a class="btn" href="/resources">Explorer les ressources</a>
</section>

<section class="features">

    <div class="card">
        <h3>Ressources</h3>
        <p>
            Accédez à des articles, guides et contenus utiles pour améliorer vos relations.
        </p>
    </div>

    <div class="card">
        <h3>Partage</h3>
        <p>
            Partagez des ressources avec d'autres utilisateurs et échangez autour des sujets importants.
        </p>
    </div>

    <div class="card">
        <h3>Progression</h3>
        <p>
            Suivez votre progression et gardez vos ressources favorites.
        </p>
    </div>

</section>

<footer>
    <p>Projet Laravel — B2 Collab</p>
</footer>

</body>
</html>