document.addEventListener('DOMContentLoaded', function() {
    var quantidadeInput = document.getElementById('quantidade');

    // evento de pressionar Enter
    quantidadeInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            pokemons(quantidadeInput.value);
        }
    });

    // chamada inicial
    pokemons(9);
});

function pokemons(quantidade) {
    fetch(`https://pokeapi.co/api/v2/pokemon?limit=${quantidade}`)
        .then(response => response.json())
        .then(allpokemon => {
            let pokemonPromises = allpokemon.results.map(poke => {
                return fetch(poke.url)
                    .then(response => response.json())
                    .then(pokemonSingle => ({
                        nome: poke.name,
                        imagem: pokemonSingle.sprites.front_default
                    }));
            });

            Promise.all(pokemonPromises)
                .then(pokemons => {
                    let pokeBoxes = document.querySelector('.pokemon-boxes');
                    pokeBoxes.innerHTML = "";

                    pokemons.forEach(pokemon => {
                        pokeBoxes.innerHTML += `
                            <div class="pokemon">
                                <img src="${pokemon.imagem}" alt="${pokemon.nome}">
                                <p>${pokemon.nome}</p>
                            </div>
                        `;
                    });
                });
        })
        .catch(error => console.error('Erro ao buscar Pokémon:', error));
}
