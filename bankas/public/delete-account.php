<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $accounts = file_get_contents(__DIR__ . '/../accounts.ser');
    $accounts = $accounts ? unserialize($accounts) : [];
    $id = (int) $_GET['id'];

    $accounts = array_filter($accounts, fn ($acc) => $id != $acc['id']);

    $accounts = serialize($accounts);
    file_put_contents(__DIR__ . '/../accounts.ser', $accounts);
    header('Location: ./');
    die;
}