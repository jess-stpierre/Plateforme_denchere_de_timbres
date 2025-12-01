{{ include('layouts/header.php', {title:"Changement d'informations"})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu"> Changement d'informations de membre </h1>
        <form method="post" class="flex-col-center">
            <label>
                Nom
                <input type="text" name="nom" value="{{ membre.nom }}">
            </label>
            {% if errors.nom is defined %}
                <span class="error">{{ errors.nom }}</span>
            {% endif %}
            <label>
                Courriel
                <input type="email" name="courriel" value="{{ membre.courriel }}">
            </label>
            {% if errors.courriel is defined %}
                <span class="error">{{ errors.courriel }}</span>
            {% endif %}
            <input type="submit" class="bouton bouton-secondaire" value="Sauvegarder">
        </form>
    </div>
</main>

{{ include('layouts/footer.php')}}