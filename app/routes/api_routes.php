<?php

// Importe a classe controladora
require_once '../app/controllers/ControllersAPI.php';

// Instancie a classe controladora

use app\controllers\ControllersAPI;


$api = new ControllersAPI();

if (isset($_GET['route'])) {
    $route=$_GET['route'];
} else {
    $route="";
    echo "Faltam parâmetros para o correto funcionamento desta API";
}

// Rota para obter os dados de todas as listas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $route === 'obter_listas') {
    $listas = $api->obterListas();
    $response = array('listas' => $listas);
    //echo json_encode($response);
}

// Rota para obter os dados de uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $route === 'obter_lista') {
    $listaId = $_GET['id'];
    $lista = $api->obterLista($listaId);
    $produtos = $api->obterProdutos($listaId);
    $response = array('lista' => $lista, 'produtos' => $produtos);
    //echo json_encode($response);
}

// Rota para criar uma nova lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'criar_lista') {
    $data = json_decode(file_get_contents('php://input'), true);
    $titulo = $data['titulo'];
    $listaId = $api->criarLista($titulo);
    $response = array('listaId' => $listaId);
   // echo json_encode($response);
}

// Rota para apagar uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'excluir_lista') {
    $data = json_decode(file_get_contents('php://input'), true);
    $listaId = $_GET['id'];
    $api->deletarLista($listaId);
    $response='Lista apagada com sucesso';
    //echo json_encode('Lista apagada com sucesso');
}

// Rota para adicionar um produto a uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'adicionar_produto') {
    $data = json_decode(file_get_contents('php://input'), true);
    $listaId = $data['listaId'];
    $nome = $data['nome'];
    $quantidade = $data['quantidade'];
    $api->adicionarProduto($listaId, $nome, $quantidade);
    $response='Produto adicionado com sucesso';
    //echo json_encode('Produto adicionado com sucesso');
}

// Rota para remover um produto de uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'remover_produto') {
    $data = json_decode(file_get_contents('php://input'), true);
    $produtoId = $data['produtoId'];
    $api->removerProduto($produtoId);
    $response='Produto removido com sucesso';
   // echo json_encode('Produto removido com sucesso');
}

// Rota para adicionar quantidade a um produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'adicionar_quantidade') {
    $data = json_decode(file_get_contents('php://input'), true);
    $produtoId = $data['produtoId'];
    $quantidade = $data['quantidade'];
    $api->adicionarQuantidade($produtoId, $quantidade);
    $response='Quantidade adicionada com sucesso';
    //echo json_encode('Quantidade adicionada com sucesso');
}

// Rota para diminuir quantidade de um produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'diminuir_quantidade') {
    $data = json_decode(file_get_contents('php://input'), true);
    $produtoId = $data['produtoId'];
    $quantidade = $data['quantidade'];
    $api->diminuirQuantidade($produtoId, $quantidade);
    $response='Quantidade diminuída com sucesso';
    //echo json_encode('Quantidade diminuída com sucesso');
}

// Rota para duplicar uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'duplicar_lista') {
    $data = json_decode(file_get_contents('php://input'), true);
    $listaId = $data['listaId'];
    $novaListaId = $api->duplicarLista($listaId);
    $response = array('novaListaId' => $novaListaId);
    //echo json_encode($response);
}

require_once '../app/views/api/index.php';