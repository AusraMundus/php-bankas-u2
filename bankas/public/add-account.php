<?php

// Bank account generator
function generateLithuanianIBAN() {
    $countryCode = 'LT';
    $bankAccountNumber = sprintf('%016d', mt_rand(0, 99999999999999));

    $accountNo = $countryCode . '00' . $bankAccountNumber;

    // Calculate the checksum digits
    $ibanDigits = str_split($accountNo);
    $checksum = 0;
    foreach ($ibanDigits as $digit) {
        $checksum = ($checksum * 10 + intval($digit)) % 97;
    }
    $checksumDigits = sprintf('%02d', 98 - $checksum);

    // Replace the placeholder checksum with the calculated checksum digits
    $accountNumber = substr_replace($accountNo, $checksumDigits, 2, 2);

    return $accountNo;
}
$accountNo = generateLithuanianIBAN();

// Account data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$accounts = file_get_contents(__DIR__ . '/../accounts.ser');
$accounts = $accounts ? unserialize($accounts) : [];

$accounts[] = [
    'firstName' => $_POST['firstName'],
    'lastName' => $_POST['lastName'],
    'personalId' => $_POST['personalId'],
    'accountNo' => $_POST['accountNo'],
    'balance' => $_POST['balance'],
    'id' => rand(100000000, 999999999)
];
$accounts = serialize($accounts);
file_put_contents(__DIR__ . '/../accounts.ser', $accounts);
header('Location: ./');
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
    <title>Pridėti sąskaitą</title>
</head>

<body>

    <?php require __DIR__ . '/menu.php' ?>

    <div class="card">
        <h5 class="card-header">Pridėkite naują sąskaitą</h5>
        <div class="card-body">
            
            <form class="row g-3" form action="./add-account.php" method="post">
                <div class="col-md-6">
                    <label for="firstName" class="form-label">Vardas</label>
                    <input type="text" class="form-control" name="firstName" placeholder="...">
                </div>
                <div class="col-md-6">
                <label for="lastName" class="form-label">Pavardė</label>
                    <input type="text" class="form-control" name="lastName" placeholder="...">
                </div>
                <div class="col-md-6">
                    <label for="personalId" class="form-label">Asmens kodas</label>
                    <input type="text" class="form-control" name="personalId" placeholder="...">
                </div>
                <div class="col-md-6">
                    <label for="accountNo" class="form-label">Banko sąskaitos numeris</label>
                    <input type="text" class="form-control" name="accountNo" aria-label="input example" value="<?= $accountNo?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="balance" class="form-label">Balansas</label>
                    <input type="text" class="form-control" name="balance" placeholder="0 Eur">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">IŠSAUGOTI</button>
                </div>
            </form>

        </div>
    </div>

</body>

</html>