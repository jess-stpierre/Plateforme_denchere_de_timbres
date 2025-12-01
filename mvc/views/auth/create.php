{{ include('layouts/header.php', {title:'Se Connecter'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu">Se Connecter</h1>
        {% if errors is defined %}
        <div class="error">
            <ul>
                {% for error in errors %}
                <li>{{ error }}</li>
                {% endfor %}
            </ul>
        </div>
        {% endif %}
        <form method="post" class="flex-col-center">
            <label>Nom d'utilisateur
                <input type="email" name="nom_dutilisateur" value="{{membre.nom_dutilisateur}}">
            </label>
            <label>Mot de Passe
                <input type="password" name="mot_de_passe" value="{{membre.mot_de_passe}}">
            </label>
            <input class="bouton bouton-secondaire" type="submit" value="Se Connecter">
        </form>
    </div>
</main>

{{ include('layouts/footer.php')}}