<?php

$accounts = file_get_contents(__DIR__ . '/../accounts.ser');
$accounts = $accounts ? unserialize($accounts) : [];

$alert = $_GET['alert'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app.css">
    <script src="app.js"></script>
    <title>Administravimo panelė</title>
</head>

<body>

    <?php require __DIR__ . '/menu.php' ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">
                    <h5 class="card-header">Banko klientai</h5>
                    <div class="card-body">

                        <table class="table">
                            <thead class="text-wrap">
                                <tr>
                                    <th scope="col">Vardas</th>
                                    <th scope="col">Pavardė</th>
                                    <th scope="col">Asmens kodas</th>
                                    <th scope="col">Sąskaitos Nr.</th>
                                    <th scope="col" class="text-center">Balansas</th>
                                    <th colspan="2" class="text-center">Disponavimas lėšomis</th>
                                    <th scope="col" class="text-center">Sąskaitos panaikinimas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $account) : ?>
                                    <tr>
                                        <td><?= $account['firstName'] ?></td>
                                        <td><?= $account['lastName'] ?></td>
                                        <td><?= $account['personalId'] ?></td>
                                        <td><?= $account['accountNo'] ?></td>
                                        <td>
                                            <div class="input-group">
                                                <div class="form-control text-end balance-bg"><?= $account['balance'] ?></div>
                                                <span class="input-group-text">€</span>
                                            </div>
                                        </td>



                                        <td>
                                            <form class="text-end" action="./add-money.php?id=<?= $account['id'] ?>" method="post">
                                                <button class="btn btn-outline-success">PRIDĖTI</button>
                                            </form>
                                        </td>

                                        <td>
                                            <form action="./withdraw-money.php?id=<?= $account['id'] ?>" method="post">
                                                <button class="btn btn-outline-secondary">IŠIMTI</button>
                                            </form>
                                        </td>

                                        <td>
                                            <form class="text-center" action="./delete-account.php?id=<?= $account['id'] ?>" method="post">
                                                <button type="submit" class="btn btn-outline-danger">IŠTRINTI</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                    </div>
                </div>

                <div><?php require __DIR__ . '/alert-msg.php' ?></div>

            </div>
        </div>
    </div>

</body>

</html>