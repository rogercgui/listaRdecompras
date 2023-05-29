<?php
namespace app\controllers;

use app\models\ModelLista;
use SQLite3;

class ControllersProdutos {
    private $db;
    
    public function __construct() {
        $this->db = new SQLite3('../db/lista_compras.db');

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

}