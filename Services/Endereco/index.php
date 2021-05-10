<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
$data = [];

require_once "../../Models/Endereco.php";

$fn = $_REQUEST["fn"] ?? null;
$id = $_REQUEST["id"] ?? 0;
$endereco =  new Endereco();
$endereco->setId($id);

if($fn === "read"){
    $data["endereco"] = $endereco->read();
}

die((json_encode($data)));