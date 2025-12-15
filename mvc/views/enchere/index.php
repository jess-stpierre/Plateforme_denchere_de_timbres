{{ include('layouts/header.php', {title:'Portail des Encheres'})}}

<main id="contenu-principal" class="flex-gap">
<div id="filtres">
            <fieldset>
                <legend>Couleur</legend>

                {% for couleur in couleurs %}
                    <div class="filtre-couleurs">
                        <input type="radio" name="couleur" id="{{ couleur.nom }}" value="{{ couleur.nom }}" class="input input-couleurs input-radio">
                        <label for="{{ couleur.nom }}">{{ couleur.nom }}</label>
                    </div>
                {% endfor %}

            </fieldset>
            <fieldset>
                <legend>Année de publication</legend>

                {% for annee in annees %}
                    <div class="filtre-annee">
                        <input type="radio" name="annee" id="{{ annee }}" value="{{ annee }}" class="input input-annees input-radio">
                        <label for="{{ annee }}">{{ annee }}</label>
                    </div>
                {% endfor %}

            </fieldset>
            <fieldset>
                <legend>Pays d'origine</legend>

                {% for pays in paysdorigines %}
                    <div class="filtre-pays">
                        <input type="radio" id="{{ pays.nom }}" name="pays" value="{{ pays.nom }}" class="input input-pays input-radio">
                        <label for="{{ pays.nom }}">{{ pays.nom }}</label>
                    </div>
                {% endfor %}

            </fieldset>
            <fieldset>
                <legend>Condition</legend>

                {% for condition in conditions %}
                    <div class="filtre-condition">
                        <input type="radio" id="{{condition.nom}}" name="condition" value="{{condition.nom}}" class="input input-condition">
                        <label for="{{condition.nom}}">{{condition.nom}}</label>
                    </div>
                {% endfor %}
            </fieldset>
            <fieldset>
                <legend>Certifié</legend>

                {% for certifie in certifies %}
                    <div class="filtre-certifie">
                        <input type="radio" id="{{certifie}}" name="certifie" value="{{certifie}}" class="input input-certifie">
                        <label for="{{certifie}}">{{certifie}}</label>
                    </div>
                {% endfor %}

            </fieldset>

            <fieldset>
                <legend>Prix</legend>

                {% for prix in prixx %}
                    <div class="filtre-prix">
                        <input type="radio" name="prix" id="{{ prix }}" value="{{ prix }}" class="input input-prix input-radio">
                        <label for="{{ prix }}">{{ prix }}$</label>
                    </div>
                {% endfor %}

            </fieldset>
        </div>
    <section id="encheres" class="flex-gap">
        <div class="resultats flex-gap">
            <h1 class="milieu">Portail des Encheres</h1>
        </div>
        <ul class="grille">
            {% for data in datas %}
                <li class="enchere flex-gap"
                    data-id="{{data.id}}"
                    data-couleur="{{data.couleur}}"
                    data-annee="{{data.annee}}"
                    data-pays="{{data.pays}}"
                    data-condition="{{data.condition}}"
                    data-certifie="{{data.certifie}}"
                    data-prix="{{data.prixx}}"
                    >
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