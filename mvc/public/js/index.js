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
    const prixRadioList = document.querySelectorAll(".input-prix");
    const statuRadioList = document.querySelectorAll(".input-statu");
    const coupsRadioList = document.querySelectorAll(".input-coupsDeCoeur");

    const resetCouleur = document.querySelector("#resetCouleur");
    checkResetPressed(resetCouleur, "couleur", listeEncheres);
    const resetAnnee = document.querySelector("#resetAnnee");
    checkResetPressed(resetAnnee, "annee", listeEncheres);
    const resetPays = document.querySelector("#resetPays");
    checkResetPressed(resetPays, "pays", listeEncheres);
    const resetCondition = document.querySelector("#resetCondition");
    checkResetPressed(resetCondition, "condition", listeEncheres);
    const resetCertifie = document.querySelector("#resetCertifie");
    checkResetPressed(resetCertifie, "certifie", listeEncheres);
    const resetPrix = document.querySelector("#resetPrix");
    checkResetPressed(resetPrix, "prix", listeEncheres);
    const resetArchiver = document.querySelector("#resetArchiver");
    checkResetPressed(resetArchiver, "statu", listeEncheres);
    const resetCoups = document.querySelector("#resetCoups");
    checkResetPressed(resetCoups, "coups", listeEncheres);

    checkRadioPressed(
      listeEncheres,
      colorRadioList,
      anneeRadioList,
      paysRadioList,
      condRadioList,
      certRadioList,
      prixRadioList,
      statuRadioList,
      coupsRadioList
    );
  }
}

function checkResetPressed(reset, name, listeEncheres) {
  reset.addEventListener("click", function (event) {
    resetRadio(name, listeEncheres);
  });
}

function resetRadio(name, listeEncheres) {
  const radioList = document.getElementsByName(name);
  for (let i = 0; i < radioList.length; i++) {
    radioList[i].checked = false;
    clearSelection(radioList[i], listeEncheres, name);
  }
}

function clearSelection(radio, listeEncheres, name) {
  let index = radiosClicked.indexOf(name);
  if (index !== -1) {
    radiosClicked.splice(index, 1);
    radiosSelected.splice(index, 1);
  }

  for (const enchere of listeEncheres) {
    let shouldShow = true;

    for (let i = 0; i < radiosSelected.length; i++) {
      const filterType = radiosClicked[i];
      const filterValue = radiosSelected[i].getAttribute("value");
      const enchereValue = checkEnchereType(filterType, enchere);

      if (filterValue !== enchereValue) {
        shouldShow = false;
        break;
      }
    }
    if (shouldShow) {
      enchere.classList.remove("visuellement-cache");
    } else {
      enchere.classList.add("visuellement-cache");
    }
  }
}

function checkRadioPressed(
  listeEncheres,
  colorRadioList,
  anneeRadioList,
  paysRadioList,
  condRadioList,
  certRadioList,
  prixRadioList,
  statuRadioList,
  coupsRadioList
) {
  colorRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "couleur");
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

  prixRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "prix");
    });
  });

  statuRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "statu");
    });
  });

  coupsRadioList.forEach(function (radio) {
    radio.addEventListener("change", function (event) {
      filtrer(event.target, listeEncheres, "coups");
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
      const filterValue = radiosSelected[i].getAttribute("value");
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
  if (typeCheck == "couleur") {
    return enchere.getAttribute("data-couleur");
  } else if (typeCheck == "pays") {
    return enchere.getAttribute("data-pays");
  } else if (typeCheck == "annee") {
    return enchere.getAttribute("data-annee");
  } else if (typeCheck == "condition") {
    return enchere.getAttribute("data-condition");
  } else if (typeCheck == "certifie") {
    return enchere.getAttribute("data-certifie");
  } else if (typeCheck == "prix") {
    return enchere.getAttribute("data-prix");
  } else if (typeCheck == "statu") {
    return enchere.getAttribute("data-statu");
  } else if (typeCheck == "coups") {
    return enchere.getAttribute("data-coups");
  }
}

window.addEventListener("load", initialiser);
