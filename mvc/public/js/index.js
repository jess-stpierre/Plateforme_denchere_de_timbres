let radiosClicked = [];

let radiosSelected = [];

let listFiltrers = [];

function initialiser() {
  const checkIfOnCorrectPage = document.querySelector("#filtres");

  if (checkIfOnCorrectPage) {
    const listeEncheres = document.querySelectorAll(".enchere");
    const colorRadioList = document.querySelectorAll(".input-couleurs");
    const anneeRadioList = document.querySelectorAll(".input-annees");
    const paysRadioList = document.querySelectorAll(".input-pays");
    const condRadioList = document.querySelectorAll(".input-condition");
    const certRadioList = document.querySelectorAll(".input-certifie");

    check(
      listeEncheres,
      colorRadioList,
      anneeRadioList,
      paysRadioList,
      condRadioList,
      certRadioList
    );
  }
}

function check(
  listeEncheres,
  colorRadioList,
  anneeRadioList,
  paysRadioList,
  condRadioList,
  certRadioList
) {
  colorRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "color");
    });
  });

  anneeRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "annee");
    });
  });

  paysRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "pays");
    });
  });

  condRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "condition");
    });
  });

  certRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "certifie");
    });
  });
}

function filtrer(radio, listeEncheres, type) {
  let index = radiosClicked.indexOf(type);
  if (index !== -1) {
    radiosClicked.splice(index, 1);
    radiosSelected.splice(index, 1);
  }

  radiosClicked.push(type);
  radiosSelected.push(radio);

  listFiltrers = [];

  for (const enchere of listeEncheres) {
    let shouldShow = true;

    for (let i = 0; i < radiosSelected.length; i++) {
      const filterType = radiosClicked[i];
      const filterValue = radiosSelected[i].getAttribute("id");
      const enchereValue = checkEnchereType(filterType, enchere);

      if (filterValue !== enchereValue) {
        shouldShow = false;
        break;
      }
    }
    if (shouldShow) {
      enchere.classList.remove("visuellement-cache");
      listFiltrers.push(enchere);
    } else {
      enchere.classList.add("visuellement-cache");
    }
  }
}

function checkEnchereType(typeCheck, enchere) {
  if (typeCheck == "color") {
    return enchere.getAttribute("data-couleur");
  } else if (typeCheck == "pays") {
    return enchere.getAttribute("data-pays");
  } else if (typeCheck == "annee") {
    return enchere.getAttribute("data-annee");
  } else if (typeCheck == "condition") {
    return enchere.getAttribute("data-condition");
  } else if (typeCheck == "certifie") {
    return enchere.getAttribute("data-certifie");
  }
}

window.addEventListener("load", initialiser);
