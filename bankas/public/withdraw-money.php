<?php

$accounts = file_get_contents(__DIR__ . '/../accounts.ser');
$accounts = $accounts ? unserialize($accounts) : [];

$alert =$_GET['alert'] ?? 0;

// Show account details
$accountId = $_GET['id'] ?? null;
$account = null;
if ($accountId) {
    foreach ($accounts as $acc) {
        if ($acc['id'] == $accountId) {
            $account = $acc;
            break;
        }
    }
}

// Withdraw money
$accountId = (int)$_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($accounts as &$a) {
        if ($a['id'] == $accountId) {
            if ($a['balance'] >= $_POST['amount']) {
                $a['balance'] -= $_POST['amount'];
            } else {
                header('Location: ./withdraw-money.php?id=' . $accountId . '&alert=4');
                die;
            }
        }
    }
    unset($a);

    $accounts = serialize($accounts);
    file_put_contents(__DIR__ . '/../accounts.ser', $accounts);
    header('Location: ./withdraw-money.php?id=' . $accountId);
    die;
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
    <title>Išimti lėšų</title>
</head>

<body>

    <?php require __DIR__ . '/menu.php' ?>

    <div class="card">
        <h5 class="card-header">Išimkite lėšų</h5>
        <div class="card-body">

            <table class="table">
                <tbody>
                    <?php if ($account) : ?>
                        <tr>
                            <td><?= $account['firstName'] ?></td>
                            <td><?= $account['lastName'] ?></td>
                            <td><?= $account['personalId'] ?></td>
                            <td><?= $account['accountNo'] ?></td>
                            <td><?= $account['balance'] ?> Eur</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <form class="row g-3" form action="./withdraw-money.php?id=<?= $accountId ?>" method="post">
                <div class="col-12">
                    <label for="amount" class="form-label">Įveskite sumą</label>
                    <input type="number" class="form-control" name="amount" placeholder="...">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning">IŠIMTI</button>
                </div>
            </form>

            <div class="col-12 link">
                <a href="http://localhost/php-bankas-u2/bankas/public/">Grįžti į pagrindinį</a>
            </div>

        </div>
    </div>

    <div><?php require __DIR__ .'/alert-msg.php'?></div>

</body>

</html>