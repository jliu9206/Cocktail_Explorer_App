<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorite Cocktails - Cocktail Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .card-img-top {
            width: 100%;
            height: 300px; 
            object-fit: cover; 
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
                        <a class="nav-link active" href="favorites.php">Favorites</a>
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
    <h1>Favorite Cocktails</h1>
    <div id="favoritesContainer" class="row"></div>
</div>

<footer class="text-white text-center p-3 mt-5">
    <p>© 2024 Cocktail Explorer. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function loadFavorites() {
        fetch('fetch_favorite.php')
        .then(response => response.json())
        .then(data => {
            const favoritesContainer = document.getElementById('favoritesContainer');
            favoritesContainer.innerHTML = data.map(fav => `
                <div class="col-md-4 mb-3">
                <div class="card">
                <img src="${fav.img_URL}" class="card-img-top" alt="${fav.cocktail_name}">
                <div class="card-body">
                <h5 class="card-title">${fav.cocktail_name}</h5>
                <a href="cocktail-details.php?id=${fav.cocktail_id}" class="btn btn-custom">View Details</a>
                <button onclick="removeFavorite('${fav.cocktail_id}')" class="btn btn-warning">Remove</button>
                </div>
                </div>
                </div>
                `).join('');
        })
        .catch(error => console.error('Error loading favorites:', error));
    }

    function removeFavorite(cocktailId) {
        fetch('delete_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: cocktailId })
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
        loadFavorites(); // Reload the list after deletion
    })
        .catch(error => console.error('Error removing favorite:', error));
    }

    window.onload = loadFavorites;
</script>
</body>
</html>
