<?php

// Importe a classe controladora
require_once '../app/controllers/ControllersListas.php';
require_once '../app/controllers/ControllersProdutos.php';

// Instancie a classe controladora

use app\controllers\ControllersListas;
use app\controllers\ControllersProdutos;


$api_L = new ControllersListas();
$api_P = new ControllersProdutos();

if (isset($_GET['route'])) {
    $route=$_GET['route'];
} else {
    $route="";
    echo "Faltam parâmetros para o correto funcionamento desta API";
}

// Rota para obter os dados de todas as listas
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $route === 'obter_listas') {
    $listas = $api_L->obterListas();
    $response = array('listas' => $listas);
    //echo json_encode($response);
}

// Rota para obter os dados de uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $route === 'obter_lista') {
    $listaId = $_GET['id'];
    $lista = $api_L->obterLista($listaId);
    $produtos = $api_P->obterProdutos($listaId);
    $response = array('lista' => $lista, 'produtos' => $produtos);
    //echo json_encode($response);
}

// Rota para criar uma nova lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'criar_lista') {
    $data = json_decode(file_get_contents('php://input'), true);
    $titulo = $data['titulo'];
    $listaId = $api_L->criarLista($titulo);
    $response = array('listaId' => $listaId);
}

// Rota para apagar uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'excluir_lista') {
    $data = json_decode(file_get_contents('php://input'), true);
    $listaId = $_GET['id'];
    $api_L->deletarLista($listaId);
    $response='Lista apagada com sucesso';
}

// Rota para alterar o nome de uma lista
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'renomear_lista') {
    $data = json_decode(file_get_contents('php://input'), true);
    $listaId = $_GET['id'];
    $titulo = $_GET['titulo'];
    $api_L->mudarTituloLista($titulo, $listaId);
    $response='Título da listas alterado para: '.$titulo;
}

// Rota para adicionar um produto a uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'adicionar_produto') {
    $data = json_decode(file_get_contents('php://input'), true);
    $listaId = $data['listaId'];
    $nome = $data['nome'];
    $quantidade = $data['quantidade'];
    $api_P->adicionarProduto($listaId, $nome, $quantidade);
    $response='Produto adicionado com sucesso '.$listaId;
}

// Rota para remover um produto de uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'remover_produto') {
    $data = json_decode(file_get_contents('php://input'), true);
    $produtoId = $data['produtoId'];
    $api_P->removerProduto($produtoId);
    $response='Produto removido com sucesso';
   // echo json_encode('Produto removido com sucesso');
}

// Rota para adicionar quantidade a um produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'adicionar_quantidade') {
    $data = json_decode(file_get_contents('php://input'), true);
    $produtoId = $data['produtoId'];
    $quantidade = $data['quantidade'];
    $api_P->adicionarQuantidade($produtoId, $quantidade);
    $response='Quantidade adicionada com sucesso';
    //echo json_encode('Quantidade adicionada com sucesso');
}

// Rota para diminuir quantidade de um produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'diminuir_quantidade') {
    $data = json_decode(file_get_contents('php://input'), true);
    $produtoId = $data['produtoId'];
    $quantidade = $data['quantidade'];
    $api_P->diminuirQuantidade($produtoId, $quantidade);
    $response='Quantidade diminuída com sucesso';
    //echo json_encode('Quantidade diminuída com sucesso');
}

// Rota para duplicar uma lista de compras
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $route === 'duplicar_lista') {
    $data = json_decode(file_get_contents('php://input'), true);
    $listaId = $data['listaId'];
    $novaListaId = $api_L->duplicarLista($listaId);
    $response = array('novaListaId' => $novaListaId);
    //echo json_encode($response);
}

require_once '../app/views/api/index.php';