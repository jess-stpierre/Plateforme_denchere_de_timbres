{{ include('layouts/header.php', {title:'Portail des Encheres'})}}

<main id="contenu-principal" class="flex-gap">
<div id="filtres">
            <fieldset>
                <legend>Couleur</legend>

                {% for couleur in couleurs %}

                    <div class="filtre-couleurs">
                        <input type="radio" name="couleur" id="{{ couleur.nom }}" value="{{ couleur.nom }}" class="input input-couleurs">
                        <label for="{{ couleur.nom }}">{{ couleur.nom }}</label>
                    </div>

                {% endfor %}

            </fieldset>
            <fieldset>
                <legend>Année de publication</legend>

                <div class="filtre-annee">
                <input type="radio" name="annee" id="1800" value="1800" class="input">
                <label for="1800">1800 - 1850</label></div>

                <div class="filtre-annee">
                <input type="radio" name="annee" id="1851" value="1851" class="input">
                <label for="1851">1851 - 1900</label></div>

                <div class="filtre-annee">
                <input type="radio" name="annee" id="1901" value="1901" class="input">
                <label for="1901">1901 - 1950</label></div>

                <div class="filtre-annee">
                <input type="radio" name="annee" id="1951" value="1951" class="input">
                <label for="1951">1951 - 2000</label></div>

                <div class="filtre-annee">
                <input type="radio" name="annee" id="2001" value="2001" class="input">
                <label for="2001">2001 - 2050</label></div>

            </fieldset>
            <fieldset>
                <legend>Pays d'origine</legend>

                <div class="filtre-pays"><input type="radio" id="Canada" name="pays" value="Canada" class="input">
                <label for="Canada">Canada</label></div>

                <div class="filtre-pays"><input type="radio" id="US" name="pays" value="US" class="input">
                <label for="US">États-Unis</label></div>

                <div class="filtre-pays"><input type="radio" id="France" name="pays" value="France" class="input">
                <label for="France">France</label></div>

                <div class="filtre-pays"><input type="radio" id="Allemagne" name="pays" value="Allemagne" class="input">
                <label for="Allemagne">Allemagne</label></div>

                <div class="filtre-pays"><input type="radio" id="Royaume-Uni" name="pays" value="Royaume-Uni" class="input">
                <label for="Royaume-Uni">Royaume-Uni</label></div>

                <div class="filtre-pays"><input type="radio" id="Italie" name="pays" value="Italie" class="input">
                <label for="Italie">Italie</label></div>

                <div class="filtre-pays"><input type="radio" id="Bresil" name="pays" value="Bresil" class="input">
                <label for="Bresil">Brésil</label></div>

                <div class="filtre-pays"><input type="radio" id="Egypte" name="pays" value="Egypte" class="input">
                <label for="Egypte">Égypte</label></div>

                <div class="filtre-pays"><input type="radio" id="Chine" name="pays" value="Chine" class="input">
                <label for="Chine">Chine</label></div>

                <div class="filtre-pays"><input type="radio" id="Japon" name="pays" value="Japon" class="input">
                <label for="Japon">Japon</label></div>

                <div class="filtre-pays"><input type="radio" id="Australie" name="pays" value="Australie" class="input">
                <label for="Australie">Australie</label></div>
            </fieldset>
            <fieldset>
                <legend>Condition</legend>

                <div class="filtre-condition"><input type="radio" id="Parfaite" name="condition" value="Parfaite" class="input">
                <label for="Parfaite">Parfaite</label></div>

                <div class="filtre-condition"><input type="radio" id="Excellente" name="condition" value="Excellente" class="input">
                <label for="Excellente">Excellente</label></div>

                <div class="filtre-condition"><input type="radio" id="Bonne" name="condition" value="Bonne" class="input">
                <label for="Bonne">Bonne</label></div>

                <div class="filtre-condition"><input type="radio" id="Moyenne" name="condition" value="Moyenne" class="input">
                <label for="Moyenne">Moyenne</label></div>

                <div class="filtre-condition"><input type="radio" id="Endommage" name="condition" value="Endommage" class="input">
                <label for="Endommage">Endommagé</label></div>
            </fieldset>
            <fieldset>
                <legend>Certifié</legend>

                <div class="filtre-certifie"><input type="radio" id="Oui" name="certifie" value="Oui" class="input">
                <label for="Oui">Oui</label></div>

                <div class="filtre-certifie"><input type="radio" id="Non" name="certifie" value="Non" class="input">
                <label for="Non">Non</label></div>

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
                    data-annee="{{data.annee}}}"
                    data-pays="{{data.pays}}"
                    data-condition="{{data.condition}}"
                    data-certifie="{{data.certifie}}"
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