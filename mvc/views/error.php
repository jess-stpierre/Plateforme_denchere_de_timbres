{{ include('layouts/header.php', {title:'Error'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="error milieu">Erreur 404</h1>
        <p class="milieu">Message: {{ msg }}</p>
    </div>
</main>

{{ include('layouts/footer.php')}}