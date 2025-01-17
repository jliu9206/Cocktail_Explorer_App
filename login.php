<?php session_start(); ?>
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
    <style>

        .container {
            max-width: 960px;
        }
        .main-heading {
            font-weight: 500;
            margin-bottom: 30px;
            color: #343a40;
        }
        .login-section {
            padding: 30px;
            border-right: 2px solid #dee2e6;
        }
        .register-section {
            padding: 30px;
        }

    </style>
</head>
<body>
    <div class="text-center mt-5">
        <h1 class="main-heading">Welcome to the Cocktail Explorer Application!</h1>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- Login Form -->
            <div class="col-md-6 login-section">
                <h2>Been here before? Login!</h2>
                <form action="loginServlet.php" method="post"> 
                    <div class="mb-3">
                        <label for="loginUsername" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="loginUsername" name="username" placeholder="Enter username here" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter password here" required>
                    </div>
                    <button type="submit" id="login" class="btn btn-custom w-100">Login</button>
                </form>

            </div>
            <!-- Registration Form -->
            <div class="col-md-6 register-section">
                <h2>New? Create an account!</h2>
                <form action="register.php" method="post"> 
                    <div class="mb-3">
                        <label for="registerUsername" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="registerUsername" name="username" placeholder="Enter username here" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="registerPassword" name="password" placeholder="Enter password here" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" placeholder="Enter email here" required>
                    </div>
                    <button type="submit" class="btn btn-custom w-100 mt-3">Continue</button>
                </form>
            </div>
        </div>
        <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= $_SESSION['error_message']; ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    </div>

    <footer class="text-white text-center p-3 mt-5">
        <p>© 2024 Cocktail Explorer. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
