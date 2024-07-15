<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>POKÉDEX PHP</title>
</head>
<body>
    <section class="main">
        <h2>Pokedex PHP</h2>
        <form method="post">
            <input type="text" name="quantidade" placeholder="Digite a quantidade de pokemons que deseja">
            <input type="submit" value="Buscar">
        </form>
        <div class="pokemon-boxes">
            <?php
            // Verifica se foi feita uma requisição via POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Verifica se o campo 'quantidade' foi enviado e se é um número válido
                if (isset($_POST['quantidade']) && is_numeric($_POST['quantidade'])) {
                    $quantidade = $_POST['quantidade'];
                    $pokemons = buscarPokemons($quantidade);

                    // Exibe os cards dos pokemons
                    foreach ($pokemons['results'] as $pokemon) {
                        $pokemonSingle = buscarPokemonPorUrl($pokemon['url']);
                        $nome = $pokemon['name'];
                        $imagem = $pokemonSingle['sprites']['front_default'];

                        echo '<div class="pokemon">';
                        echo '<img src="' . $imagem . '" alt="' . $nome . '">';
                        echo '<p>' . ucfirst($nome) . '</p>'; // ucfirst para capitalizar o nome
                        echo '</div>';
                    }
                }
            }

            function buscarPokemons($quantidade) {
                $url = "https://pokeapi.co/api/v2/pokemon?limit={$quantidade}";
                $response = file_get_contents($url);
                return json_decode($response, true);
            }

            function buscarPokemonPorUrl($url) {
                $response = file_get_contents($url);
                return json_decode($response, true);
            }
            ?>
        </div>
    </section>
</body>
</html>
