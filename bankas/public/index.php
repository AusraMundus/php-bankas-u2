<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app.css">
    <script src="app.js"></script>
    <title>Bankas - Sveiki atvykę!</title>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header welcome-align navbar-brand">
                        <img src="logo.png" alt="logo">
                        <h1>Easy Way To Manage Bank Accounts</h1>
                    </div>
                    <div class="card-body">
                        <div class="welcome-align row g-3">

                            <?php if (isset($_SESSION['email'])) : ?>
                                <div>
                                    <a class="btn btn-secondary btn-act" href="http://localhost/php-bankas-u2/bankas/public/main.php">Grįžti į administravimo panelę</a>
                                </div>
                                <form action="http://localhost/php-bankas-u2/bankas/public/login.php?logout" method="post">
                                    <button type="submit" class="btn btn-dark btn-act">Atsijungti "<?= $_SESSION['email'] ?>"</button>
                                </form>

                            <?php else : ?>
                                <div>
                                    <a class="btn btn-secondary" href="http://localhost/php-bankas-u2/bankas/public/login.php">Prisijungti</a>
                                </div>

                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>