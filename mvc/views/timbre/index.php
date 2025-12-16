{{ include('layouts/header.php', {title:'Liste de mes Timbres Publier'})}}

<main>
    <br><br>
    <div class="container flex-col">
        <h1 class="milieu">Liste de mes Timbres Publier</h1>
        <table>
            <tr>
                <th>Nom</th>
                <th>Date de Creation</th>
                <th>Description</th>
            </tr>
            {% for timbre in timbres %}
            <tr>
                <td><a class="bouton bouton-secondaire" href="{{base}}/timbre/show?id={{ timbre.id }}">{{ timbre.nom }}</a></td>
                <td>{{ timbre.date_de_creation }}</td>
                <td>{{ timbre.description }}</td>
            </tr>
            {% endfor %}
        </table>
        <br>
        <a href="{{base}}/timbre/create" class="bouton bouton-principal milieu">Publier un Timbre</a>
    </div>
    <br><br>
</main>


{{ include('layouts/footer.php')}}

