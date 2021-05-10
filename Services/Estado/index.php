<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
$data = [];

require_once "../../Models/Estado.php";

$fn = $_REQUEST["fn"] ?? null;
$id = $_REQUEST["id"] ?? 0;
$nome = $_REQUEST["nome"] ?? null;
$uf = $_REQUEST["UF"] ?? null;
$estado =  new Estado();
$estado->setId($id);

if($fn === "read"){
    $data["estado"] = $estado->read();
}

die((json_encode($data)));