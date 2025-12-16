{{ include('layouts/header.php', {title:'Liste de mes Mises'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu">Liste de mes Mises</h1>
        <table>
            <tr>
                <th>Nom du timbre</th>
                <th>Montant de la mise</th>
                <th>Date de la mise</th>
            </tr>
            {% for data in datas %}
            <tr>
                <td><a class="bouton bouton-secondaire" href="{{base}}/enchere/show?id={{ data.enchere_id }}">{{ data.nom_du_timbre }}</a></td>
                <td>{{ data.montant }}$</td>
                <td>{{ data.date_de_loffre }}</td>
            </tr>
            {% endfor %}
        </table>
        <br>
    </div>
</main>


{{ include('layouts/footer.php')}}
