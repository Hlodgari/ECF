"use strict"

// Récupération des éléments du DOM
const nosPizzas = document.getElementById("contenuNosPizzas");
const pizzasTomate = document.getElementById("contenuTomate");
const pizzasCreme = document.getElementById("contenuCreme");
const btnTomate = document.getElementById("baseTomate");
const btnCreme = document.getElementById("baseCreme");
const btnPizza = document.getElementById("nosPizzas");
const formLogin = document.getElementById("formLogin");
const formRegister = document.getElementById("formRegister");

// Tableau des promesses de fetch pour récupérer les données des pizzas
const pizzas = [
    fetch('http://localhost/ECF/ECF-Back-end/src/index.php?route=pizzas')
];

console.log(pizzas);

let dataArray = [];

// Récupération des données des pizzas et affichage
Promise.all(pizzas)
    .then(responses => Promise.all(responses.map(response => response.json())))
    .then(data => {
        dataArray = data.flat();
        console.log(data);
        afficherContenu(dataArray);
    })
    .catch(error => {
        console.error("Erreur lors du chargement des pizzas :", error);
    });

// Fonction pour afficher le contenu des pizzas
function afficherContenu(data) {
    nosPizzas.innerHTML = "";

    data.forEach(pizza => {
        const card = document.createElement("div");
        card.classList.add("card", "g-col-2", "bg-secondary-subtle", "my-4", "mx-2", "d-flex", "flex-column", "align-items-center", "justify-content-between");
        card.setAttribute("style", "width: 16rem");

        const img = document.createElement("img");
        img.classList.add("card-img-top");
        img.setAttribute("src", pizza.image.chemin);
        img.setAttribute("alt", pizza.nom);

        const nom = document.createElement("h4");
        nom.classList.add("text-center", "mt-2");
        nom.textContent = pizza.nom;

        const ingredients = document.createElement("ul");
        ingredients.textContent = "Ingrédients :";
        ingredients.classList.add("list-unstyled", "text-center", "my-2");
        const ingredient = document.createElement("li");
        ingredient.textContent = pizza.ingredients.reduce((acc, ingredient) => acc + ", " + ingredient);
        ingredients.appendChild(ingredient);

        const ligne = document.createElement("hr");

        const footer = document.createElement("div");
        footer.classList.add("d-flex", "justify-content-between", "align-items-center", "w-100", "px-2", "mt-auto");

        const prix = document.createElement("p");
        prix.classList.add("mb-0");
        prix.textContent = `Prix : ${pizza.prix} ${pizza.devise}`;

        const btn = document.createElement("a");
        btn.classList.add("btn", "btn-success", "justify-content-center", "d-flex");
        btn.setAttribute("href", "#");
        btn.textContent = "Ajouter";
        btn.setAttribute("id", pizza.nom);

        btn.addEventListener("click", function () {
            ajouterAuPanier(pizza);
        });

        card.appendChild(img);
        card.appendChild(nom);
        card.appendChild(ligne);
        card.appendChild(ingredients);
        card.appendChild(ligne);
        card.appendChild(footer);
        footer.appendChild(prix);
        footer.appendChild(btn);
        nosPizzas.appendChild(card);
    });
}

// Ajout des écouteurs d'événements pour les boutons de filtrage
btnTomate.addEventListener("click", filtrerPizza);
btnCreme.addEventListener("click", filtrerPizza);
btnPizza.addEventListener("click", filtrerPizza);


// Fonction pour filtrer les pizzas en fonction de la base
function filtrerPizza(event) {
    const base = event.target.id;

    if (base === "baseTomate") {
        const pizzasTomate = dataArray.filter(pizza => pizza.base === "tomate");
        afficherContenu(pizzasTomate);
    } else if (base === "baseCreme") {
        const pizzasCreme = dataArray.filter(pizza => pizza.base === "creme");
        afficherContenu(pizzasCreme);
    } else {
        afficherContenu(dataArray);
    }
}

// Récupération des éléments du DOM pour les modals
const modalPanier = document.getElementById("myModalPanier");
const btnPanier = document.getElementById("ouvrirModalPanier");
const spanPanier = document.getElementsByClassName("closePanier")[0];

const modalProfil = document.getElementById("myModalProfil");
const btnProfil = document.getElementById("ouvrirModalProfil");
const spanProfil = document.getElementsByClassName("closeProfil")[0];

const modalLogin = document.getElementById("myModalLogin");
const btnLogin = document.getElementById("ouvrirModalLogin");
const spanLogin = document.getElementsByClassName("closeLogin")[0];

// Fonction pour gérer l'ouverture et la fermeture des modals
function gererModal(modal, btn, span) {
    btn.addEventListener("click", function () {
        modal.style.display = "block";
    });

    span.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
}

// Appel de la fonction pour gérer les modals
gererModal(modalPanier, btnPanier, spanPanier);
gererModal(modalProfil, btnProfil, spanProfil);
gererModal(modalLogin, btnLogin, spanLogin);

let panier = [];

// Fonction pour ajouter une pizza au panier
function ajouterAuPanier(pizza) {
    const pizzaExistante = panier.find(item => item.nom === pizza.nom);
    if (pizzaExistante) {
        pizzaExistante.quantité += 1;
    } else {
        panier.push({ ...pizza, quantité: 1 });
    }
    console.log(panier);
    afficherPanier();
}

// Fonction pour afficher le contenu du panier
function afficherPanier() {
    const panierContenu = document.getElementById("contenuPanier");
    panierContenu.innerHTML = "";
    const notif = document.getElementById("notifPanier");
    let totalPrix = 0;

    panier.forEach(pizza => {
        const row = document.createElement("div");
        row.classList.add("d-flex", "flex-wrap", "align-items-center", "mb-3");

        const img = document.createElement("img");
        img.setAttribute("src", pizza.image.chemin);
        img.setAttribute("alt", pizza.nom);
        img.setAttribute("style", "width: 50px; height: 50px; margin-right: 10px;");

        const nom = document.createElement("span");
        nom.textContent = pizza.nom;
        nom.classList.add("col");

        const quantité = document.createElement("span");
        quantité.textContent = `Quantité : ${pizza.quantité}`;
        quantité.classList.add("col");

        const btnMoins = document.createElement("button");
        btnMoins.textContent = "-";
        btnMoins.classList.add("btn", "btn-sm", "btn-outline-secondary", "col-1");
        btnMoins.addEventListener("click", function () {
            ajusterQuantite(pizza, -1);
        });

        const btnPlus = document.createElement("button");
        btnPlus.textContent = "+";
        btnPlus.classList.add("btn", "btn-sm", "btn-outline-secondary", "col-1");
        btnPlus.addEventListener("click", function () {
            ajusterQuantite(pizza, 1);
        });

        const prix = document.createElement("span");
        const sousTotal = pizza.quantité * pizza.prix;
        prix.textContent = `Sous-total : ${sousTotal} ${pizza.devise}`;
        prix.classList.add("col");

        const btnSupprimer = document.createElement("button");
        btnSupprimer.textContent = "Supp.";
        btnSupprimer.classList.add("btn", "btn-outline-danger", "btn-sm", "col-1");
        btnSupprimer.addEventListener("click", function () {
            supprimerPizza(pizza);
        });

        row.appendChild(img);
        row.appendChild(nom);
        row.appendChild(quantité);
        row.appendChild(btnMoins);
        row.appendChild(btnPlus);
        row.appendChild(prix);
        row.appendChild(btnSupprimer);
        panierContenu.appendChild(row);

        totalPrix += sousTotal;
    });

    const totalPrixElement = document.getElementById("totalPrix");
    totalPrixElement.textContent = `Total : ${totalPrix.toFixed(2)} €`;
}

// Fonction pour ajuster la quantité d'une pizza dans le panier
function ajusterQuantite(pizza, nbPizza) {
    const pizzaExistante = panier.find(item => item.nom === pizza.nom);
    if (pizzaExistante) {
        pizzaExistante.quantité = Math.max(1, pizzaExistante.quantité + nbPizza);
    }
    afficherPanier();
}

// Fonction pour supprimer une pizza du panier
function supprimerPizza(pizza) {
    panier = panier.filter(item => item.nom !== pizza.nom);
    afficherPanier();
}

// Fonction pour mettre à jour la notification du panier
function mettreAJourNotif() {
    const notif = document.getElementById("notifPanier");
    const totalQuantite = panier.reduce((total, pizza) => total + pizza.quantité, 0);
    notif.textContent = totalQuantite;

    if (totalQuantite === 0) {
        notif.classList.add("d-none");
    } else {
        notif.classList.remove("d-none");
        notif.classList.add("d-flex");
    }
}

// Appel de la fonction mettreAJourNotif après chaque modification du panier
ajouterAuPanier = (function(originalAjouterAuPanier) {
    return function(pizza) {
        originalAjouterAuPanier(pizza);
        mettreAJourNotif();
    };
})(ajouterAuPanier);

ajusterQuantite = (function(originalAjusterQuantite) {
    return function(pizza, nbPizza) {
        originalAjusterQuantite(pizza, nbPizza);
        mettreAJourNotif();
    };
})(ajusterQuantite);

supprimerPizza = (function(originalSupprimerPizza) {
    return function(pizza) {
        originalSupprimerPizza(pizza);
        mettreAJourNotif();
    };
})(supprimerPizza);


// Gestions d'inscription
formRegister.addEventListener("submit", async function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    try {
        const response = await fetch('http://localhost/ECF/ECF-Back-end/src/index.php?route=register', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();
        console.log(result);
    } catch (error) {
        console.error("Erreur lors de l'inscription :", error);
    }
});

// Gestion de la connexion

formLogin.addEventListener("submit", async function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    try {
        const response = await fetch('http://localhost/ECF/ECF-Back-end/src/index.php?route=login', {
            method: 'POST',
            body: formData,
        });

        const result = await response.json();
        console.log(result);
    } catch (error) {
        console.error("Erreur lors de la connexion :", error);
    }
});

// Gestion de la déconnexion

