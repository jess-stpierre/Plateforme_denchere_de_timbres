class Filtre {
  #radio;
  #listeEncheres;

  constructor(radio, listeEncheres, type) {
    this.#radio = radio;
    this.#listeEncheres = listeEncheres;

    if (type === "color") {
      this.filtrerByColor();
    }
  }

  filtrerByColor() {
    const wantedColor = this.#radio.getAttribute("id");

    this.#listeEncheres.forEach(function (enchere) {
      let enchereColor = enchere.getAttribute("data-couleur");

      if (wantedColor != enchereColor) {
        enchere.classList.add("visuellement-cache");
      } else {
        enchere.classList.remove("visuellement-cache");
      }
    });
  }
}

export default Filtre;
