<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover Cocktails - Cocktail Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .card {
            overflow: hidden; /* Ensures content does not flow outside the card */
            position: relative;
            cursor: pointer;
        }
        .card-img-top {
            transition: transform 0.3s ease, opacity 0.3s ease;
            width: 100%;
            object-fit: cover;
        }
        .card-body {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            color: white;
            text-align: center;
        }
        .card:hover .card-img-top {
            transform: scale(1.1); /* Zooms in the image slightly */
            opacity: 0.3;
        }
        .card:hover .card-body {
            opacity: 1;
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
                        <a class="nav-link active" aria-current="page" href="discover.php">Discover</a>
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
                <a href="login.php" class="btn">Login</a>
            <?php endif; ?>                
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1>Discover Your Favorite Cocktails</h1>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search cocktails by name" id="searchName">
        <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
    </div>
    <div class="mb-3">
        <select class="form-select" id="filterSpirit">
            <option selected value="">Filter by base spirit</option>
            <option value="Vodka">Vodka</option>
            <option value="Rum">Rum</option>
            <option value="Gin">Gin</option>
            <option value="Tequila">Tequila</option>
        </select>
    </div>
    <div id="resultsContainer" class="row mt-3">
        <!-- Search results will be populated here -->
    </div>
</div>

<footer class="text-white text-center p-3 mt-5">
    <p>© 2024 Cocktail Explorer. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function loadInitialData() {
        const popularLetters = ['a', 'c', 'm', 't']; 
        popularLetters.forEach(letter => {
            fetch(`https://www.thecocktaildb.com/api/json/v1/1/search.php?f=${letter}`)
            .then(response => response.json())
            .then(data => {
                if (data.drinks) {
                    populateResults(data.drinks);
                }
            })
            .catch(error => console.error('Error fetching data for letter ' + letter + ': ', error));
        });
    }

    function populateResults(drinks) {
        const resultsContainer = document.getElementById('resultsContainer');
        drinks.forEach(drink => {
            const cardHtml = `
            <div class="col-md-3 mb-4">
            <div class="card h-100">
            <img src="${drink.strDrinkThumb}/preview" class="card-img-top" alt="${drink.strDrink}">
            <div class="card-body">
            <h5 class="card-title">${drink.strDrink}</h5>
            <a href="cocktail-details.php?id=${drink.idDrink}" class="btn btn-custom">View Details</a>
            </div>
            </div>
            </div>
            `;
            resultsContainer.innerHTML += cardHtml;
        });
    }

    document.getElementById('searchButton').addEventListener('click', function() {
        const searchName = document.getElementById('searchName').value;
        const filterSpirit = document.getElementById('filterSpirit').value;
        let url = `https://www.thecocktaildb.com/api/json/v1/1/search.php?s=${searchName}`;

        if (filterSpirit) {
            url = `https://www.thecocktaildb.com/api/json/v1/1/filter.php?i=${filterSpirit}`;
        }

        fetch(url)
        .then(response => response.json())
        .then(data => {
                    document.getElementById('resultsContainer').innerHTML = ''; // Clear previous results
                    if (data.drinks) {
                        populateResults(data.drinks);
                    } else {
                        document.getElementById('resultsContainer').innerHTML = '<p>No results found.</p>';
                    }
                })
        .catch(error => {
            console.error('Error fetching data: ', error);
            document.getElementById('resultsContainer').innerHTML = '<p>No results found or there was an error.</p>';
        });
    });

    window.onload = loadInitialData;
</script>
</body>
</html>
