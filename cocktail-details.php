<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocktail Details - Cocktail Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style type="text/css">
        #cocktail{
            height: 500px;
            width: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Cocktail Explorer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="discover.php">Discover</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="favorites.php">Favorites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>

                <?php if (isset($_SESSION['username'])): ?>
                    <p class="navbar-text-light" id="loggedin">
                      Logged in as <?= htmlspecialchars($_SESSION['username']); ?>
                  </p>
                  <button onclick="location.href='logout.php'" class="btn" type="button">Logout</button>
              <?php else: ?>
                <a href="login.php" class="btn btn">Login</a>
            <?php endif; ?>     
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div id="cocktailDetails" class="row">
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <button onclick="addToFavorites()" class="btn btn-custom">Add to Favorites</button>
        </div>
    </div>
</div>



<footer class="text-white text-center p-3 mt-5">
    <p>© 2024 Cocktail Explorer. All rights reserved.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function fetchCocktailDetails() {
        const params = new URLSearchParams(window.location.search);
            const id = params.get('id'); // Get the cocktail ID from URL query string

            if (id) {
                fetch(`https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.drinks) {
                        displayCocktailDetails(data.drinks[0]);
                    } else {
                        document.getElementById('cocktailDetails').innerHTML = '<p>No details found for this cocktail.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching cocktail details: ', error);
                    document.getElementById('cocktailDetails').innerHTML = '<p>Error loading cocktail details.</p>';
                });
            }
        }
function addToFavorites() {
    const cocktailData = {
        id: document.location.search.replace('?id=', ''),
        name: document.querySelector('.cname').innerText,
        image: document.querySelector('.img-fluid').src
    };

    fetch('add_to_favorites.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(cocktailData)
    })
    .then(response => response.text())
    .then(text => {
        alert(text);
    })
    .catch(error => {
        console.error('Error adding to favorites: ', error);
        alert('Failed to add to favorites.');
    });
}
        function displayCocktailDetails(cocktail) {
            const detailsHtml = `
            <div class="col-md-6">
            <img src="${cocktail.strDrinkThumb}" class="img-fluid" id="cocktail" alt="${cocktail.strDrink}">
            </div>
            <div class="col-md-6">
            <h2 class="cname">${cocktail.strDrink}</h2>
            <p>${cocktail.strInstructions}</p>
            <h5>Ingredients:</h5>
            <ul>
            ${getIngredients(cocktail).join('')}
            </ul>
            </div>
            `;
            document.getElementById('cocktailDetails').innerHTML = detailsHtml;
        }

        function getIngredients(cocktail) {
            let ingredients = [];
            for (let i = 1; i <= 15; i++) { // Loop through possible ingredients
                if (cocktail[`strIngredient${i}`]) {
                    ingredients.push(`<li>${cocktail[`strIngredient${i}`]} - ${cocktail[`strMeasure${i}`] || ''}</li>`);
                }
            }
            return ingredients;
        }

        window.onload = fetchCocktailDetails;
    </script>
</body>
</html>
