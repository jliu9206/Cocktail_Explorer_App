<?php session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Cocktail Explorer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> 
    <style type="text/css">

        .card-img-top {
            width: 100%; 
            height: 300px; 
            object-fit: cover; 
        }
        .img-fluid {
            max-width: 100%;
            height: auto;
            border-radius: 5px; 
            margin-top: 30px; 
        }
        .card-body .btn {
            margin-top: auto;
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
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
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
                <a href="login.php" class="btn btn-outline-success">Login</a>
            <?php endif; ?>  
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1 class="display-4">Discover Your Favorite Cocktails</h1>
            <p class="lead">Explore recipes and ingredients behind your favorite drinks.</p>
            <a href="discover.php" class="btn btn-custom btn-lg">Start Exploring</a>
        </div>
        <div class="col-lg-6">
            <img src="img/landing.jpeg" class="img-fluid" alt="Cocktail Image">
        </div>
    </div>
</div>

<section class="my-5">
    <div class="container text-center">
        <h2>Featured Cocktails</h2>
        <div class="row mt-4">
            <div class="col-md-3 d-flex align-items-stretch">
                <div class="card">
                    <img src="img/margarita.jpeg" class="card-img-top" alt="Margarita">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Margarita</h5>
                        <p class="card-text">A classic cocktail known for its simplicity and refreshing taste.</p>
                        <a href="cocktail-details.php?id=11007" class="btn btn-custom">View Recipe</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch">
                <div class="card">
                    <img src="img/mojito.jpeg" class="card-img-top" alt="Mojito">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Mojito</h5>
                        <p class="card-text">A Cuban cocktail combining white rum, sugar, lime juice, soda water, and mint.</p>
                        <a href="cocktail-details.php?id=11000" class="btn btn-custom">View Recipe</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch">
                <div class="card">
                    <img src="img/old_fashioned.jpeg" class="card-img-top" alt="Old Fashioned">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Old Fashioned</h5>
                        <p class="card-text">This cocktail is a blend of whiskey, bitters, sugar, and a few dashes of water.</p>
                        <a href="cocktail-details.php?id=11001" class="btn btn-custom">View Recipe</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-stretch">
                <div class="card">
                    <img src="img/cosmopolitan.jpeg" class="card-img-top" alt="Cosmopolitan">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Cosmopolitan</h5>
                        <p class="card-text">Vodka, triple sec, cranberry juice, and freshly squeezed or sweetened lime juice.</p>
                        <a href="cocktail-details.php?id=17196" class="btn btn-custom">View Recipe</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="text-white text-center p-3 mt-5">
    <p>© 2024 Cocktail Explorer. All rights reserved.</p>
</footer>

<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
