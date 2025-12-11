{{ include('layouts/header.php', {title:"Détail d'Enchère"})}}

<main id="contenu-principal" class="flex-gap centre colonnes">
    <div class="resultats flex-gap">
        <h1>Détail d'Enchère</h1>
    </div>
    <div>
        <section class="bordure">
            <h2 class="flex-gap centre">{{ timbre.nom }}</h2>
            <div class="flex-gap centre">
                <div class="flex-gap colonnes">
                {% for image in images %}
                    <img src="{{ asset ~ image.image_url }}" class="photo-galerie" alt="{{ image.description_courte }}">
                {% endfor %}
                </div>
                <div class="flex-gap colonnes colonnes-petit">
                    <img id="image-primaire" src="{{ asset ~ images[0].image_url }}" alt="{{ images[0].description_courte }}">
                    <div id="fleches-changement" class="flex-gap">
                        <a href="#"><</a>
                        <a href="#">(+)</a>
                        <a href="#">></a>
                    </div>
                    <p class="flex-gap centre">{{ timbre.description }}</p>
                </div>
                <section class="flex-gap colonnes centre">
                    {% if enchere.coups_de_coeur == 1 %}
                        <h3>*COUPS DE COEUR DU LORD*</h3>
                    {% endif %}
                    <span>Temps restant: <span>{{ temps }}</span></span>

                    {% for error in errors %}
                        <span class="error">{{ error }}</span>
                    {% endfor %}

                    <form action="{{base}}/enchere/show?id={{ enchere.id }}" method="post" class="flex-gap colonnes">
                        <input type="hidden" name="enchere_id" value="{{ enchere.id }}">
                        <div id="offre" class="conteneur flex-gap colonnes centre">
                            <p>Prix plancher: <span>{{ enchere.prix_plancher }}</span>$</p>
                            <p>Offre actuelle: <span>{{ enchere.prix_courant }}</span>$</p>
                            <p>par: <span>*X*</span></p>
                            <div id="prix" class="bg-input">
                                <label for="cad" class="visuellement-cache">Le montant de CAD$ que vous voulez misez</label>
                                <input class="bg-input" type="decimal" name="montant" id="cad" placeholder="Faire une mise - $CAD">
                            </div>
                        </div>
                        <div id="mise" class="conteneur flex-gap colonnes centre">
                            <p>Nombres de mises: <span>*X*</span></p>
                            <input type="submit" value="Placer une mise" class="bouton bouton-principal">
                        </div>
                    </form>
                </section>
            </div>
        </section>
        <section class="bordure">
            <h2 class="flex-gap centre">Details du Timbre</h2>
            <div class="flex-gap centre detail-du-timbre">
                <div>
                    <p>Date de création: <span>{{ timbre.date_de_creation}}</span></p>
                    <p>Pays d’origine: <span>{{ pays }}</span></p>
                    <p>Tirage: <span>{{ timbre.tirage }}</span></p>
                    {% if timbre.certifie == 0 %}
                        <p>Certifié: <span> Non </span></p>
                    {% else %}
                        <p>Certifié: <span> Oui </span></p>
                    {% endif %}
                </div>
                <div>
                    <p>Couleurs: <span>{{ couleur }}</span></p>
                    <p>Condition: <span>{{ condition }}</span></p>
                    <p>Dimensions: <span>{{ timbre.dimensions }}</span></p>
                </div>
            </div>
        </section>
    </div>
</main>

{{ include('layouts/footer.php')}}