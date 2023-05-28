<?php

namespace app\controllers;

use app\models\ModelLista;

class ControllersLayout {
    private $listaDeCompras;
    private $productModel;

    public function __construct() {
        $this->listaDeCompras = new ModelLista();
    }

    public function topnavbar() {
        require 'app/views/public/top_navbar.php';
    }
    
    public function index() {
        $lists = $this->listaDeCompras->obterListas();
        require 'app/views/public/index.php';
    }

    public function footer() {
        require 'app/views/public/footer.php';
    }



}
?>