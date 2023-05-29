<?php
namespace app\controllers;

use app\models\ModelLista;
use SQLite3;

class ControllersAPI {
    private $db;
    
    public function __construct() {
        $this->db = new SQLite3('../db/lista_compras.db');

        // Criar tabela 'listas' se não existir
        $query = 'CREATE TABLE IF NOT EXISTS listas (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    titulo TEXT
                )';
        $this->db->exec($query);

        // Criar tabela 'produtos' se não existir
        $query = 'CREATE TABLE IF NOT EXISTS produtos (
                    id_prod INTEGER PRIMARY KEY AUTOINCREMENT,
                    lista_id INTEGER,
                    nome TEXT,
                    quantidade INTEGER,
                    FOREIGN KEY (lista_id) REFERENCES listas(id) ON DELETE CASCADE
                )';
        $this->db->exec($query);
    }

    // Ver todas as listas de compras
    public function obterListas() {
        $query = "SELECT * FROM listas";
        $results = $this->db->query($query);
        $listas = array();
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $listas[] = $row;
        }
        return $listas;

    }

    // Cria uma lista de compras
    public function criarLista($titulo) {
        $query = "INSERT INTO listas (titulo) VALUES ('$titulo')";
        $this->db->exec($query);
        $listaId = $this->db->lastInsertRowID();
        return $listaId;
    }

    // Apaga uma lista de compras
    public function deletarLista($listaId) {
        $query = "DELETE FROM produtos WHERE lista_id = $listaId";
        $query_prod = "DELETE FROM listas WHERE id = $listaId";
        $this->db->exec($query);
        $this->db->exec($query_prod);
    }

    // Altera o nome de uma lista
    public function mudarTituloLista($titulo, $listaId) {
        $query = "UPDATE listas SET titulo = '$titulo' WHERE id = $listaId";
        $this->db->exec($query);
    }

    // Adiciona um produto a uma lista de compras (id, nome, quantidade)
    public function adicionarProduto($listaId, $nome, $quantidade) {
        $query = "INSERT INTO produtos (lista_id, nome, quantidade) VALUES ($listaId, '$nome', $quantidade)";
        $this->db->exec($query);
    }

    // Remove a linha inteira do produto
    public function removerProduto($produtoId) {
        $query = "DELETE FROM produtos WHERE id_prod = $produtoId";
        $this->db->exec($query);
    }

    // Exibe 1 lista de compras com o seu ID
    public function obterLista($listaId) {
        $query = "SELECT * FROM listas WHERE id = $listaId";
        $result = $this->db->querySingle($query, true);
        

        if ($result==0) {
            header("Location: ../index.php");
            exit;
        } else {
            return $result;
        }
    }

    // Lista os produtos de uma lista informando o ID da lista
    public function obterProdutos($listaId) {
        $query = "SELECT * FROM produtos WHERE lista_id = $listaId";
        $results = $this->db->query($query);
        $produtos = array();
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $produtos[] = $row;
        }
        return $produtos;
    }

    // Adiciona quantidade ao produto de uma lista
    public function adicionarQuantidade($produtoId, $quantidade) {
        $query = "UPDATE produtos SET quantidade = quantidade + $quantidade WHERE id_prod = $produtoId";
        $this->db->exec($query);
    }

    // Remove quantidade ao produto de uma lista
    public function diminuirQuantidade($produtoId, $quantidade) {
        $query = "UPDATE produtos SET quantidade = quantidade - $quantidade WHERE id_prod = $produtoId";
        $this->db->exec($query);
    }

    // Duplica uma lista de compras
    public function duplicarLista($listaId) {
        $lista = $this->obterLista($listaId);
        $produtos = $this->obterProdutos($listaId);

        $novaListaId = $this->criarLista($lista['titulo']);

        foreach ($produtos as $produto) {
            $this->adicionarProduto($novaListaId, $produto['nome'], $produto['quantidade']);
        }

        return $novaListaId;
    }
}