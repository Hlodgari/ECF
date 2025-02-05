"use strict"

const pizzas = [
    { name: 'Margherita' },
    { name: 'Quatre Fromages' },
    { name: 'Bolognaise' },
    { name: 'Carbonara' },
    { name: 'Chèvre Miel' },
    { name: 'Vosgienne' },
    { name: 'Champignon' },
    { name: 'Chicken' }
];

pizzas.forEach(commande => {
    const div = document.createElement('div');
    div.classList.add('pizza', 'p-2', 'mt-2', 'border', 'rounded','bg-light');
    div.textContent = commande.name;

    const button = document.createElement('button');
    button.textContent = 'Suivant';
    button.classList.add('btn', 'btn-success', 'btn-sm', 'mt-2');
    button.addEventListener('click', () => avancerPizza(button));

    div.appendChild(document.createElement('br'));
    div.appendChild(button);
    document.getElementById('commandes').appendChild(div);
});

function avancerPizza(button) {
    const columnOrder = ['commandes', 'preparation', 'cuisson', 'livraison'];
    const pizzaDiv = button.parentElement;
    const currentColumn = pizzaDiv.parentElement.id;
    const nextIndex = columnOrder.indexOf(currentColumn) + 1;

    if (nextIndex < columnOrder.length) {
        document.getElementById(columnOrder[nextIndex]).appendChild(pizzaDiv);
    }
    
    if (nextIndex === columnOrder.length - 1) {
        button.textContent = "Livrée";
        button.addEventListener('click', () => supprimerPizza(pizzaDiv));
    }
}

function supprimerPizza(pizzaDiv) {
    pizzaDiv.remove();
}