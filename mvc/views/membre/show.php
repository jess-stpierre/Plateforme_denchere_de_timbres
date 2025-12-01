{{ include('layouts/header.php', {title:'Votre Profile'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu">Votre Profile</h1>
        <p><strong>Nom: </strong>{{ membre.nom }} </p>
        <p><strong>Nom d'Utilisateur: </strong>{{ membre.nom_dutilisateur }}</p>
        <p><strong>Courriel: </strong>{{ membre.courriel }}</p>
        <div class="flex-de-base">
            <a href="{{base}}/membre/edit?id={{ client.id }}" class="bouton bouton-secondaire">Changer l'information</a>
            <form action="{{base}}/membre/delete" method="post">
                <input type="hidden" name="id" value="{{ membre.id }}">
                <input type="submit" value="Supprimer le compte" class="bouton bouton-tier">
            </form>
        </div>
    </div>
</main>

{{ include('layouts/footer.php')}}