<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header('Content-Type: application/json');
$data = [];

require_once "../../Models/Usuario.php";

$fn = $_REQUEST["fn"] ?? null;
$id = $_REQUEST["id"] ?? 0;
$nome = $_REQUEST["nome"] ?? null;
$endereco = $_REQUEST["endereco_id"] ?? null;
$usuario =  new Usuario;
$usuario->setId($id);

if($fn === "create" && $nome !== null && $endereco !== null){
    $usuario->setNome($nome);
    $usuario->setEndereco_id($endereco);
    $data["usuario"] = $usuario->create();
}
if($fn === "read"){
    $data["usuario"] = $usuario->read();
}
if($fn === "readCidade"){
    $data["usuario"] = $usuario->readCidade();
}
if($fn === "readEstado"){
    $data["usuario"] = $usuario->readEstado();
}
if($fn === "update" && $nome !== null && $endereco !== null){
    $usuario->setNome($nome);
    $usuario->setEndereco_id($endereco);
    $data["usuario"] = $usuario->update();
}
if($fn === "delete" && $id > 0){
    $data["usuario"] = $usuario->delete();
}

die((json_encode($data)));