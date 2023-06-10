<?php

session_start();

if (isset($_SESSION['email']) && !isset($_GET['logout'])) {
    header('Location: http://localhost/php-bankas-u2/bankas/public/');
    die;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_GET['logout'])) {
        unset($_SESSION['email']);
        $_SESSION['alert'] = '<div class="alert alert-mini alert-success">Sėkmingai atsijungėte. Norėdami prisijungti dar kartą įveskite prisijungimo duomenis.</div>';
        header('Location: http://localhost/php-bankas-u2/bankas/public/login.php');
        die;
    }

    $users = file_get_contents(__DIR__ . '/users.json');
    $users = json_decode($users, 1);
    foreach ($users as $user) {
        if ($user['userFirstName'] == $_POST['userFirstName'] && $user['userLastName'] == $_POST['userLastName'] && $user['email'] == $_POST['email'] && $user['password'] == md5($_POST['password'])) {
            $_SESSION['email'] = $user['email'];
            header('Location: http://localhost/php-bankas-u2/bankas/public/main.php');
            die;
        }
    }
    $_SESSION['alert'] = '<div class="alert alert-mini alert-danger">Neteisingi arba neįvesti prisijungimo duomenys. Bandykite dar kartą.</div>';
    header('Location: http://localhost/php-bankas-u2/bankas/public/login.php');
    die;
}

if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
} else {
    $alert = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app.css">
    <script src="app.js"></script>
    <title>Prisijungti</title>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">

                    <div class="card-header welcome-align navbar-brand text-wrap">
                        <img src="logo.png" alt="logo">
                        <h1>Įveskite prisijungimo duomenis</h1>
                    </div>

                    <div class="card-body">
                        <form class="row g-3" method="post">
                            <div class="col-6">
                                <label for="userFirstName" class="form-label">Vardas</label>
                                <input type="text" class="form-control" name="userFirstName">
                            </div>
                            <div class="col-6">
                                <label for="userLastName" class="form-label">Pavardė</label>
                                <input type="text" class="form-control" name="userLastName">
                            </div>
                            <div class="col-6">
                                <label for="email" class="form-label">El. paštas</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="col-6">
                                <label for="email" class="form-label">Slaptažodis</label>
                                <input type="text" class="form-control" name="password">
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-secondary" type="submit">Prisijungti</button>
                            </div>
                        </form>
                    </div>

                    <?php if ($alert) : ?>
                        <h6><?= $alert ?></h6>
                    <?php endif ?>
                    
                </div>
            </div>
        </div>
    </div>

</body>

</html>