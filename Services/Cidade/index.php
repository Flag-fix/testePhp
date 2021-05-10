<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
$data = [];

require_once "../../Models/Cidade.php";

$fn = $_REQUEST["fn"] ?? null;
$id = $_REQUEST["id"] ?? 0;
$nome = $_REQUEST["nome"] ?? null;

$cidade =  new Cidade;
$cidade->setId($id);

if($fn === "read"){
    $data["cidade"] = $cidade->read();
}

die((json_encode($data)));