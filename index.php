<?php 

require  'vendor/autoload.php';

use app\controllers\ControllersLayout;

// Verifica a rota solicitada
$route = isset($_REQUEST['route']) ? $_REQUEST['route'] : '';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$listaId = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

// Instancia o controlador
$controller = new ControllersLayout();

// Header é chamado de forma permanente
$controller->topnavbar();

// Roteamento para as views correspondentes
$controller->index();

// Rodapé é chamado de forma permantente
$controller->footer();
?>


    