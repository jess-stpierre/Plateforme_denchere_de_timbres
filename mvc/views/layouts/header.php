<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Auteur: Jessica St-Pierre Gagne. Platforme d'enchères du Lord Stampee.">
    <title>Stampee - {{ title }}</title>

    <link rel="stylesheet" href="{{ asset }}css/general.css">
    <link rel="stylesheet" href="{{ asset }}css/container.css">
    <link rel="stylesheet" href="{{ asset }}css/nav.css">
    <link rel="stylesheet" href="{{ asset }}css/for-nav-toggle.css">
    <link rel="stylesheet" href="{{ asset }}css/utilitaires.css">
    <link rel="stylesheet" href="{{ asset }}css/bouton.css">
    <link rel="stylesheet" href="{{ asset }}css/filtres.css">
    <link rel="stylesheet" href="{{ asset }}css/contenu-principal.css">
    <link rel="stylesheet" href="{{ asset }}css/grille.css">
    <link rel="stylesheet" href="{{ asset }}css/footer.css">
    <link rel="stylesheet" href="{{ asset }}css/menu-deroulant.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Jost:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="nav navigation-secondaire">
            <ul class="flex-de-base menu-droite">
                <li class="menu-deroulant"><a href="#">A Propos &#x25BE;</a>
                    <ul class="sous-menu blue-fonce">
                        <li><a href="#">La philatélie</a></li>
                        <li><a href="#">Biographie</a></li>
                        <li><a href="#">Historique Familial</a></li>
                    </ul>
                </li>
                <li class="menu-deroulant"><a href="#">Contactez-Nous &#x25BE;</a>
                    <ul class="sous-menu blue-fonce">
                        <li><a href="#">Angleterre</a></li>
                        <li><a href="#">Canada</a></li>
                        <li><a href="#">US</a></li>
                        <li><a href="#">Australie</a></li>
                    </ul>
                </li>
                <li><a href="#">Termes et conditions</a></li>
            </ul>
        </nav>
        <label for="hamburger-menu" class="visuellement-cache">Menu Hamburger</label>
        <input type="checkbox" class="for-nav-toggle" id="hamburger-menu">
        <nav class="nav navigation-principal">
            <ul class="flex-de-base menu-gauche">
                <li><a href="{{base}}/home"><img src="{{ asset }}img/logo-2-alt.webp" alt="Logo Lord Stampee" class="logo"></a></li>
                <li class="menu-deroulant"><a href="#">Portail des Enchères &#x25BE;</a>
                    <ul class="sous-menu">
                        <li><a href="#">Enchères Présentes</a></li>
                        <li><a href="#">Enchères Passées</a></li>
                    </ul>
                </li>
                <li class="menu-deroulant"><a href="#">Fonctionnement &#x25BE;</a>
                    <ul class="sous-menu">
                        <li><a href="#">Aide: Profil</a></li>
                        <li><a href="#">Aide: Placez une offre</a></li>
                        <li><a href="#">Aide: Suivre une enchère</a></li>
                        <li><a href="#">Aide: Trouver une enchère désirée</a></li>
                        <li><a href="#">Contacter le webmetre</a></li>
                    </ul>
                </li>
                <li class="menu-deroulant"><a href="#">Actualités &#x25BE;</a>
                    <ul class="sous-menu">
                        <li><a href="#">Timbre</a></li>
                        <li><a href="#">Enchères</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="flex-de-base menu-milieu">
                <li class="recherche-input">
                    <label for="recherche" class="visuellement-cache">Recherche</label>
                    <input type="text" name="recherche" id="recherche" class="recherche-class" placeholder="Timbre Canada 1930">
                </li>
                <li class="bouton bouton-tier"><a href="#">Recherche</a></li>
            </ul>
            <ul class="flex-de-base menu-droite">
                {% if guest %}
                    <li class="bouton bouton-principal"><a href="{{base}}/membre/create">Devenir Membre</a></li>
                    <li class="bouton bouton-secondaire"><a href="{{base}}/login">Se Connecter</a></li>
                {% else %}
                    <li class="bouton bouton-principal"><a href="{{base}}/membre/show">Votre Profil</a></li>
                    <li class="bouton bouton-secondaire"><a href="{{base}}/logout">Se Déconnecter</a></li>
                {% endif %}
            </ul>
        </nav>
    </header>