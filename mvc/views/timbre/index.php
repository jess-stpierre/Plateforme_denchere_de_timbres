{{ include('layouts/header.php', {title:'Liste de mes Timbres Publier'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu">Liste de mes Timbres Publier</h1>
        <table>
            <tr>
                <th>Nom</th>
                <th>Date de Creation</th>
                <th>Description</th>
                <th>Tirage</th>
                <th>Dimensions</th>
            </tr>
            {% for timbre in timbres %}
            <tr>
                <td><a class="bouton bouton-secondaire" href="{{base}}/timbre/show?id={{ timbre.id }}">{{ timbre.nom }}</a></td>
                <td>{{ timbre.date_de_creation }}</td>
                <td>{{ timbre.description }}</td>
                <td>{{ timbre.tirage }}</td>
                <td>{{ timbre.dimensions }}</td>
            </tr>
            {% endfor %}
        </table>
        <br>
        <a href="{{base}}/timbre/create" class="bouton bouton-principal milieu">Publier un Timbre</a>
    </div>
</main>


{{ include('layouts/footer.php')}}

