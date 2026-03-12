<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - B2 Collab</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, 'Times New Roman', serif;
            background: #f4f4f1;
            color: #3c3c3c;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: 92%;
            max-width: 1100px;
            margin: 0 auto;
        }

        /* NAVBAR */
        .navbar-wrapper {
            padding-top: 12px;
        }

        .navbar {
            background: #6f9f8f;
            border-radius: 12px;
            padding: 10px 18px;
            display: flex;
            justify-content: center;
            gap: 18px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }

        .navbar a {
            padding: 6px 8px;
            border-radius: 6px;
            transition: 0.2s ease;
        }

        .navbar a:hover {
            background: rgba(255,255,255,0.16);
        }

        /* HERO */
        .hero {
            text-align: center;
            padding: 26px 0 10px;
        }

        .hero-quote {
            font-size: 26px;
            font-style: italic;
            margin-bottom: 28px;
            color: #444;
        }

        .search-bar {
            position: relative;
            max-width: 520px;
            margin: 0 auto;
        }

        .search-bar input {
            width: 100%;
            height: 44px;
            border: none;
            outline: none;
            border-radius: 999px;
            padding: 0 46px 0 20px;
            background: #ffffff;
            color: #555;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            font-size: 14px;
        }

        .search-bar span {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            color: #999;
        }

        /* DECORATION */
        .wave-section {
            position: relative;
            height: 110px;
            margin: 10px 0 28px;
            overflow: hidden;
        }

        .wave-line {
            position: absolute;
            left: -5%;
            width: 110%;
            height: 120px;
            border-radius: 50%;
            border: 4px solid transparent;
        }

        .wave-line.one {
            top: 4px;
            border-bottom-color: #6f9f8f;
            transform: rotate(-2deg);
        }

        .wave-line.two {
            top: 18px;
            border-bottom-color: #d7c58d;
            transform: rotate(1deg);
        }

        .wave-line.three {
            top: 32px;
            border-bottom-color: #8fb6ab;
            transform: rotate(-1deg);
        }

        /* TITLES */
        .section-title {
            display: inline-block;
            background: #ece7e1;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 22px;
            margin-bottom: 18px;
            color: #595959;
        }

        /* CATEGORIES */
        .categories-section {
            padding-bottom: 22px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .category-card {
            background: #fbfbfb;
            min-height: 120px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 16px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
            font-size: 22px;
            color: #555;
        }

        /* POPULAR RESOURCES */
        .popular-section {
            background: #5f8f82;
            margin-top: 20px;
            padding: 26px 0 34px;
        }

        .popular-section .section-title {
            background: #ece7e1;
        }

        .resources-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
        }

        .resource-card {
            background: #fbfbfb;
            border-radius: 12px;
            padding: 18px 16px 16px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .resource-card h3 {
            margin: 0 0 8px;
            font-size: 20px;
            color: #4b4b4b;
        }

        .resource-card p {
            margin: 0 0 14px;
            color: #6a6a6a;
            font-size: 15px;
        }

        .fake-line {
            height: 3px;
            background: #9db9b0;
            border-radius: 999px;
            margin-bottom: 8px;
        }

        .fake-line.short {
            width: 60%;
        }

        .fake-line.medium {
            width: 80%;
        }

        .fake-line.long {
            width: 92%;
        }

        .tag {
            display: inline-block;
            margin-top: 10px;
            background: #6f9f8f;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            padding: 5px 10px;
            border-radius: 999px;
        }

        /* FOOTER */
        footer {
            background: #d8d4d0;
            text-align: center;
            padding: 24px 12px;
            font-size: 16px;
            color: #444;
        }

        footer a {
            display: block;
            margin: 4px 0;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .resources-grid {
                grid-template-columns: 1fr;
            }

            .hero-quote {
                font-size: 22px;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                flex-wrap: wrap;
                gap: 10px;
                font-size: 12px;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .hero-quote {
                font-size: 18px;
                line-height: 1.5;
            }

            .section-title {
                font-size: 18px;
            }

            .category-card {
                min-height: 95px;
                font-size: 18px;
            }

            .resource-card h3 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>

    <div class="container navbar-wrapper">
        <nav class="navbar">
            <a href="/">Accueil</a>
            <a href="/resources">Ressources</a>
            <a href="/outils">Outils</a>
            <a href="/support">Support</a>
            <a href="/connexion">Connexion / inscription</a>
        </nav>
    </div>

    <section class="hero container">
        <div class="hero-quote">
            "Améliorez vos relations humaines au quotidien"
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Rechercher une ressource...">
            <span>🔍</span>
        </div>
    </section>

    <section class="wave-section">
        <div class="wave-line one"></div>
        <div class="wave-line two"></div>
        <div class="wave-line three"></div>
    </section>

    <section class="categories-section container">
        <div class="section-title">Les catégories principales :</div>

        <div class="categories-grid">
            <div class="category-card">Famille</div>
            <div class="category-card">Couple</div>
            <div class="category-card">Travail</div>
            <div class="category-card">Amis</div>
            <div class="category-card">Communauté</div>
            <div class="category-card">Développement personnel</div>
        </div>
    </section>

    <section class="popular-section">
        <div class="container">
            <div class="section-title">Ressources populaires</div>

            <div class="resources-grid">
                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>

                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>

                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>

                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <a href="#">Mentions légales</a>
        <a href="#">Contact</a>
        <a href="#">Lorem ipsum</a>
        <a href="#">CGU</a>
    </footer>

</body>
</html>