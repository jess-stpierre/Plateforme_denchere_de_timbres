{{ include('layouts/header.php', {title:'Creer un Compte Membre'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu">Creer un Compte Membre</h1>
        {% if errors is defined %}
        <div class="error">
            <ul>
                {% for error in errors %}
                <li>{{ error }}</li>
                {% endfor %}
            </ul>
        </div>
        {% endif %}
        <form method ="post" class="flex-col-center">
            <label>Nom
                <input type="text" name="nom" value="{{membre.nom}}">
            </label>
            <label>Nom d'Utilisateur
                <input type="email" name="nom_dutilisateur" value="{{membre.nom_dutilisateur}}">
            </label>
            <label>Mot de Passe
                <input type="password" name="mot_de_passe" value="{{membre.mot_de_passe}}">
            </label>
            <label>Courriel
                <input type="email" name="courriel" value="{{membre.courriel}}">
            </label>
            <input class="bouton bouton-secondaire" type="submit" value="Enregistrer">
        </form>
    </div>
</main>

{{ include('layouts/footer.php')}}