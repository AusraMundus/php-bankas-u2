<?php

$accounts = file_get_contents(__DIR__ . '/../accounts.ser');
$accounts = $accounts ? unserialize($accounts) : [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app.css">
    <script src="app.js"></script>
    <title>Home</title>
</head>

<body>

    <?php require __DIR__ . '/menu.php' ?>

    <div class="card">
        <h5 class="card-header">Banko sąskaitos</h5>
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Vardas</th>
                        <th scope="col">Pavardė</th>
                        <th scope="col">Asmens kodas</th>
                        <th scope="col">Sąskaitos Nr.</th>
                        <th scope="col">Balansas</th>
                        <th colspan="2">Disponavimas lėšomis</th>
                        <th scope="col">Sąskaitos panaikinimas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account) : ?>
                        <tr>
                            <td><?= $account['firstName'] ?></td>
                            <td><?= $account['lastName'] ?></td>
                            <td><?= $account['personalId'] ?></td>
                            <td><?= $account['accountNo'] ?></td>
                            <td><?= $account['balance'] ?> Eur</td>

                            <td>
                                <form action="./add-money.php?id=<?= $account['id'] ?>" method="post">
                                    <button class="btn btn-success">PRIDĖTI</button>
                                </form>
                            </td>

                            <td>
                                <form action="./withdraw-money.php?id=<?= $account['id'] ?>" method="post">
                                    <button class="btn btn-warning">IŠIMTI</button>
                                </form>
                            </td>

                            <td>
                                <form action="./delete-account.php?id=<?= $account['id'] ?>" method="post">
                                    <button type="submit" class="btn btn-danger">IŠTRINTI</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    </div>



</body>

</html>