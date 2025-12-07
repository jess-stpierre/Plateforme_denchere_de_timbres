{{ include('layouts/header.php', {title:'Votre Timbre'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu">Votre Timbre</h1>
        <p><strong>Nom: </strong>{{ timbre.nom }} </p>
        <p><strong>Date de creation: </strong>{{ timbre.date_de_creation }}</p>
        <p><strong>Description: </strong>{{ timbre.description }}</p>
        <p><strong>Tirage: </strong>{{ timbre.tirage }}</p>
        <p><strong>Dimensions: </strong>{{ timbre.dimensions }}</p>

        {% if timbre.certifie == 0 %}
        <p><strong>Certifie: </strong>Non</p>
        {% else %}
        <p><strong>Certifie: </strong>Oui</p>
        {% endif %}

        <p><strong>Couleur: </strong>{{ couleur }}</p>
        <p><strong>Pays d'Origine: </strong>{{ pays }}</p>
        <p><strong>Condition: </strong>{{ condition }}</p>

        {% for image in images %}
            <img src="{{ asset ~ image.image_url }}" alt="{{ image.description_courte }}">
        {% endfor %}

        <div class="flex-de-base wrap">
            <a href="{{base}}/timbre/edit?id={{ timbre.id }}" class="bouton bouton-secondaire">Changer le timbre</a>
            <form action="{{base}}/timbre/delete" method="post">
                <input type="hidden" name="id" value="{{ timbre.id }}">
                <input type="submit" value="Supprimer le timbre" class="bouton bouton-tier">
            </form>
        </div>
    </div>
</main>

{{ include('layouts/footer.php')}}