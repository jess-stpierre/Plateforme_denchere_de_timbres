import Filtre from "./components/Filtre.js";

// Fonctions
function initialiser() {
  const checkIfOnCorrectPage = document.querySelector("#filtres");

  if (checkIfOnCorrectPage) {
    const listeEncheres = document.querySelectorAll(".enchere");
    const colorRadioList = document.querySelectorAll(".input-couleurs");

    colorRadioList.forEach(function (radio) {
      radio.addEventListener("change", function (event) {
        filtrer(event.target, listeEncheres, "color");
      });
    });
  }
}

function filtrer(radio, listeEncheres, type) {
  new Filtre(radio, listeEncheres, type);
}

// Exécution
window.addEventListener("load", initialiser);
