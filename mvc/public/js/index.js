import Filtre from "./components/Filtre.js";

let radiosClicked = [];

let allRadios = [];

let radiosSelected = [];

// Fonctions
function initialiser() {
  const checkIfOnCorrectPage = document.querySelector("#filtres");

  if (checkIfOnCorrectPage) {
    const listeEncheres = document.querySelectorAll(".enchere");
    const colorRadioList = document.querySelectorAll(".input-couleurs");
    const anneeRadioList = document.querySelectorAll(".input-annees");
    const paysRadioList = document.querySelectorAll(".input-pays");

    allRadios = document.querySelectorAll(".input-radio");

    check(listeEncheres, colorRadioList, anneeRadioList, paysRadioList);
  }
}

function check(listeEncheres, colorRadioList, anneeRadioList, paysRadioList) {
  colorRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(
        event.target,
        listeEncheres,
        "color",
        colorRadioList,
        anneeRadioList,
        paysRadioList
      );
    });
  });

  anneeRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(
        event.target,
        listeEncheres,
        "annee",
        colorRadioList,
        anneeRadioList,
        paysRadioList
      );
    });
  });

  paysRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(
        event.target,
        listeEncheres,
        "pays",
        colorRadioList,
        anneeRadioList,
        paysRadioList
      );
    });
  });
}

function filtrer(
  radio,
  listeEncheres,
  type,
  colorRadioList,
  anneeRadioList,
  paysRadioList
) {
  let listUpdated = [];

  listeEncheres.forEach(function (enchere) {
    if (!enchere.classList.contains("visuellement-cache")) {
      listUpdated.push(enchere);
    }
  });

  let alreadyRadioClicked = radiosClicked.includes(type);

  if (radiosSelected.length == 0 || alreadyRadioClicked === false) {
    new Filtre(radio, listUpdated, type, false);
    console.log("0: " + radio.getAttribute("id"));
  }

  if (alreadyRadioClicked) {
    radiosSelected.forEach(function (radiosSel) {
      new Filtre(radiosSel, listeEncheres, type, false);
      console.log("3: " + radiosSel.getAttribute("id"));

      radiosClicked.forEach(function (typesAlreadyClicked) {
        //if (radio !== radiosSel) {
        if (typesAlreadyClicked !== type) {
          new Filtre(radiosSel, listeEncheres, typesAlreadyClicked, false);
          //new Filtre(radio, listeEncheres, type, false);
          console.log("2: " + radiosSel.getAttribute("id"));
          return;
        }

        if (typesAlreadyClicked === type) {
          //   let index = radiosClicked.indexOf(type);
          //   radiosClicked.splice(index, 1);
          new Filtre(radio, listeEncheres, type, true);
          console.log("1: " + radio.getAttribute("id"));
          //return;
          //return;
        } //else {
        return;
      });
    });

    let index = radiosClicked.indexOf(type);
    radiosClicked.splice(index, 1);
    radiosSelected.splice(index, 1);
  }

  radiosClicked.push(type);
  radiosSelected.push(radio);

  console.log(radiosSelected);
  console.log("radiosClicked: " + radiosClicked);
}



// Exécution
window.addEventListener("load", initialiser);
