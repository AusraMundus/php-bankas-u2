<?php

$alert =$_GET['alert'] ?? 0;

// IBAN generator
function generateLithuanianIBAN()
{
    $countryCode = 'LT';
    $bankAccountNumber = sprintf('%016d', mt_rand(0, 99999999999999));

    $accountNo = $countryCode . '00' . $bankAccountNumber;


    $ibanDigits = str_split($accountNo);
    $checksum = 0;
    foreach ($ibanDigits as $digit) {
        $checksum = ($checksum * 10 + intval($digit)) % 97;
    }
    $checksumDigits = sprintf('%02d', 98 - $checksum);

    $accountNo = substr_replace($accountNo, $checksumDigits, 2, 2);

    return $accountNo;
}
$accountNo = generateLithuanianIBAN();

// Add account data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $accounts = file_get_contents(__DIR__ . '/../accounts.ser');
    $accounts = $accounts ? unserialize($accounts) : [];

    // Check if personal Id has numbers and is 11 digits long
    $personalId = $_POST['personalId'];
    if (!ctype_digit($personalId) || strlen(trim($personalId)) !== 11) {
        header('Location: ./add-account.php?alert=6');
        die;
    }
    
    // Check if the first and last name longer than 3 characters
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    if (strlen($firstName) < 3 || strlen($lastName) < 3) {
        header('Location: ./add-account.php?alert=5');
        die;
    }

    // Check if personal ID already exists
    foreach ($accounts as $account) {
        if ($account['personalId'] === $personalId) {
            header('Location: ./add-account.php?alert=7');
            die;
        }
    }

    $accounts[] = [
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'personalId' => $_POST['personalId'],
        'accountNo' => $_POST['accountNo'],
        'balance' => 0,
        'id' => rand(100000000, 999999999)
    ];
    $accounts = serialize($accounts);
    file_put_contents(__DIR__ . '/../accounts.ser', $accounts);
    header('Location: ./main.php?alert=1');
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
                <div class="col-md-4">
                    <label for="firstName" class="form-label">Vardas</label>
                    <input type="text" class="form-control" name="firstName" placeholder="Įveskite vardą">
                </div>
                <div class="col-md-4">
                    <label for="lastName" class="form-label">Pavardė</label>
                    <input type="text" class="form-control" name="lastName" placeholder="Įveskite pavardę">
                </div>
                <div class="col-md-4">
                    <label for="personalId" class="form-label">Asmens kodas</label>
                    <input type="text" class="form-control" name="personalId" placeholder="Įveskite asmens kodą">
                </div>
                <div class="col-md-6">
                    <label for="accountNo" class="form-label">Banko sąskaitos numeris</label>
                    <input type="text" class="form-control" name="accountNo" aria-label="input example" value="<?= $accountNo ?>" readonly>
                </div>
                <div class="col-md-6">
                    <label for="balance" class="form-label">Balansas</label>
                    <input type="text" class="form-control" name="balance" aria-label="input example" readonly placeholder="0 €">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">IŠSAUGOTI</button>
                </div>
            </form>

            <div class="col-12 link">
                <a href="http://localhost/php-bankas-u2/bankas/public/main.php">Grįžti į pagrindinį</a>
            </div>

        </div>
    </div>

    <div><?php require __DIR__ .'/alert-msg.php'?></div>

</body>

</html>