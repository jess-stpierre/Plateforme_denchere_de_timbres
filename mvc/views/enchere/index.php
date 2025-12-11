{{ include('layouts/header.php', {title:'Portail des Encheres'})}}

<main id="contenu-principal" class="flex-gap">
    <section id="encheres" class="flex-gap">
        <div class="resultats flex-gap">
            <h1 class="milieu">Portail des Encheres</h1>
        </div>
        <ul class="grille">
            {% for data in datas %}
                <li class="enchere flex-gap">
                    <a href="{{base}}/enchere/show?id={{ data.id }}">
                        <img src="{{ asset ~ data.url }}"  alt="{{ data.description }}">
                        <h2>{{ data.nom }}</h2>
                        <p>Offre actuelle: <span>{{ data.prix }}</span>$</p>
                        <span>Temps restant: <span>{{ data.temps }}</span></span>
                    </a>
                    <div class="Mise flex-gap">
                        <span><span>{{ data.nombreDeMises }}</span> mises</span>
                        <a href="{{base}}/enchere/show?id={{ data.id }}">Misez maintenant</a>
                    </div>
                </li>
            {% endfor %}
        </ul>
    </section>
</main>

{{ include('layouts/footer.php')}}