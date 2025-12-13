class Filtre {
  #radio;
  #listeEncheres;
  #changedType;

  constructor(radio, listeEncheres, type, changedType) {
    this.#radio = radio;
    this.#listeEncheres = listeEncheres;
    this.#changedType = changedType;

    if (type === "color") {
      this.filtrerByColor();
    } else if (type === "annee") {
      this.filtrerByYear();
    } else if (type === "pays") {
      this.filtrerByCountry();
    }
  }

  filtrerByColor() {
    const wantedColor = this.#radio.getAttribute("id");

    this.#listeEncheres.forEach(
      function (enchere) {
        if (this.#changedType === true)
          enchere.classList.remove("visuellement-cache");

        if (enchere.classList.contains("visuellement-cache")) return;

        let enchereColor = enchere.getAttribute("data-couleur");

        if (wantedColor != enchereColor) {
          if (!enchere.classList.contains("visuellement-cache"))
            enchere.classList.add("visuellement-cache");
        } else {
          if (enchere.classList.contains("visuellement-cache"))
            enchere.classList.remove("visuellement-cache");
        }
      }.bind(this)
    );
  }

  filtrerByYear() {
    const wantedYear = this.#radio.getAttribute("id");

    this.#listeEncheres.forEach(
      function (enchere) {
        if (this.#changedType === true)
          enchere.classList.remove("visuellement-cache");

        if (enchere.classList.contains("visuellement-cache")) return;

        let enchereYear = enchere.getAttribute("data-annee");

        if (wantedYear != enchereYear) {
          if (!enchere.classList.contains("visuellement-cache"))
            enchere.classList.add("visuellement-cache");
        } else {
          if (enchere.classList.contains("visuellement-cache"))
            enchere.classList.remove("visuellement-cache");
        }
      }.bind(this)
    );
  }

  filtrerByCountry() {
    const wantedPays = this.#radio.getAttribute("id");

    this.#listeEncheres.forEach(
      function (enchere) {
        if (this.#changedType === true)
          enchere.classList.remove("visuellement-cache");

        if (enchere.classList.contains("visuellement-cache")) return;

        let encherePays = enchere.getAttribute("data-pays");

        if (wantedPays != encherePays) {
          if (!enchere.classList.contains("visuellement-cache"))
            enchere.classList.add("visuellement-cache");
        } else {
          if (enchere.classList.contains("visuellement-cache"))
            enchere.classList.remove("visuellement-cache");
        }
      }.bind(this)
    );
  }
}

export default Filtre;
