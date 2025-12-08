{{ include('layouts/header.php', {title:'Publier un Timbre'})}}

<main>
    <div class="container flex-col-center">
        <h1 class="milieu">Publier un Timbre</h1>
        <form method="post" class="flex-col-center" enctype="multipart/form-data">
            <label>
                Nom du timbre
                <input type="text" name="nom" value="{{ timbre.nom }}" required>
            </label>
            {% if errors.nom is defined %}
                <span class="error">{{ errors.nom }}</span>
            {% endif %}
            <label>
                Date de creation
                <input type="date" name="date_de_creation" value="{{ timbre.date_de_creation }}" required>
            </label>
            {% if errors.date_de_creation is defined %}
                <span class="error">{{ errors.date_de_creation }}</span>
            {% endif %}
            <label>
                Description
                <textarea name="description" cols="20" rows="4" required>{{ timbre.description }}</textarea>
            </label>
            {% if errors.description is defined %}
                <span class="error">{{ errors.description }}</span>
            {% endif %}
            <label>
                Tirage
                <input type="number" name="tirage" value="{{ timbre.tirage }}" required>
            </label>
            {% if errors.tirage is defined %}
                <span class="error">{{ errors.tirage }}</span>
            {% endif %}
            <label>
                Dimensions
                <input type="text" name="dimensions" value="{{ timbre.dimensions }}" required>
            </label>
            {% if errors.dimensions is defined %}
                <span class="error">{{ errors.dimensions }}</span>
            {% endif %}
            <label>
                Certifie
                <input type="checkbox" name="certifie" value="1" {% if timbre.certifie %}checked{% endif %} >
            </label>
            {% if errors.certifie is defined %}
                <span class="error">{{ errors.certifie }}</span>
            {% endif %}

            <input type="hidden" name="membre_id" value="{{ membre_id }}">

            <label class="image">
                Image Principale (obligatoire)
                <input type="file" name="image_un" accept="image/jpeg,image/png,image/webp" required data-max-size="5242880">
            </label>
            {% if errors.image_un is defined %}
                <span class="error">{{ errors.image_un }}</span>
            {% endif %}

            <label class="image">
                Image Secondaire (optionnel)
                <input type="file" name="image_deux" accept="image/jpeg,image/png,image/webp" data-max-size="5242880">
            </label>
            {% if errors.image_deux is defined %}
                <span class="error">{{ errors.image_deux }}</span>
            {% endif %}

            <label class="image">
                Image Trois (optionnel)
                <input type="file" name="image_trois" accept="image/jpeg,image/png,image/webp" data-max-size="5242880">
            </label>
            {% if errors.image_trois is defined %}
                <span class="error">{{ errors.image_trois }}</span>
            {% endif %}

            <label class="image">
                Image Quatre (optionnel)
                <input type="file" name="image_quatre" accept="image/jpeg,image/png,image/webp" data-max-size="5242880">
            </label>
            {% if errors.image_quatre is defined %}
                <span class="error">{{ errors.image_quatre }}</span>
            {% endif %}

            <label>
                Couleur
                <select name="couleur_id">
                    <option value="">Selectionner</option>
                    {% for couleur in couleurs %}
                    <option value="{{ couleur.id }}" {% if couleur.id==timbre.couleur_id %} selected {% endif %}>{{ couleur.nom }}</option>
                    {% endfor %}
                </select>
            </label>
            {% if errors.couleur_id is defined %}
                <span class="error">{{ errors.couleur_id }}</span>
            {% endif %}
            <label>
                Pays d'Origine
                <select name="pays_dorigine_id">
                    <option value="">Selectionner</option>
                    {% for pays_dorigine in paysOrigines %}
                    <option value="{{ pays_dorigine.id }}" {% if pays_dorigine.id==timbre.pays_dorigine_id %} selected {% endif %}>{{ pays_dorigine.nom }}</option>
                    {% endfor %}
                </select>
            </label>
            {% if errors.pays_dorigine_id is defined %}
                <span class="error">{{ errors.pays_dorigine_id }}</span>
            {% endif %}
            <label>
                Condition
                <select name="conditions_id">
                    <option value="">Selectionner</option>
                    {% for conditions in condition %}
                    <option value="{{ conditions.id }}" {% if conditions.id==timbre.conditions_id %} selected {% endif %}>{{ conditions.nom }}</option>
                    {% endfor %}
                </select>
            </label>
            {% if errors.conditions_id is defined %}
                <span class="error">{{ errors.conditions_id }}</span>
            {% endif %}
            <input class="bouton bouton-secondaire" type="submit" value="Publier">
        </form>
    </div>
</main>

{{ include('layouts/footer.php')}}