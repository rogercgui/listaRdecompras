  <div class="d-flex align-items-center p-3 my-3 bg-purple rounded shadow-sm">
    <div class="container mt-3">

        <!--  Formulário para criação de uma lista -->
        <h3>Criar uma lista</h3>
        <form id="formCriarLista"  class="row row-cols-lg-auto g-3 align-items-center">
            <label for="titulo">Título da Lista:</label>
            <div class="col-12">
                <input type="text" class="form-control" id="titulo" required>
            </div>
            <div class="col-12">
             <button type="submit" class="btn btn-primary">Criar Lista</button>
            </div>
        </form>

        <div id="listaProdutos" style="display: none;">
        <!--  Exibe o título da lista e o botão Editar título -->
        <div class="row">
            <h2>
            <span id="listaTitulo" class="d-inline"></span>
            <button type="button" class="btn btn-sm btn-default editar-titulo" >Editar</button>
            </h2>
            <form id="FormEditarTitulo" style="display: none;" class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-12">
                    <label>Modifique o título da lista</label>
                </div>
                <div class="col-12">
                    <input type="text" id="EditaTitulo" class="form-control" value="" name="titulo">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
        
                    
        <!--  Form para adicionar produtos -->
        <div class="row row-cols-lg-auto g-3 align-items-center">
            <form id="formAdicionarProduto" class="row row-cols-lg-auto g-3 align-items-center">
                <div class="col-12">
                    <input type="text" class="form-control" id="nomeProduto" placeholder="Nome do Produto" required>
                    <input type="hidden" class="form-control" name="listaId" id="idLista" >
                </div>
                <div class="col-12">
                    <input type="number" class="form-control" id="quantidadeProduto" placeholder="Quantidade" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Adicionar Produto</button>
                </div>
            </form>
        </div>

            <!--Tabela de produtos-->
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaProdutos"></tbody>
            </table>

            <!--Form para duplicar uma lista-->
            <form id="formDuplicarLista" style="display: none;">
                <input type="hidden" id="listaIdDuplicar">
                <a href="index.php"  class="btn btn-success">Concluir lista</a>
            </form>
        </div>
        
    </div>
  </div>


  <!--Looping com as listas-->
  <div class="my-3 p-3 bg-body rounded shadow-sm">
    <h6 class="border-bottom pb-2 mb-0">Listas de compras</h6>
    <?php foreach (array_reverse($lists) as $list): ?>
        <div class="d-flex justify-content-between  pt-3 border border-start-0 border-end-0">
            <div class="col-2 col-sm-1" id="EditarListas">
            <button id="ver" data-id="<?php echo $list['id']; ?>" onclick="topFunction()" title="Add this item" class="editar btn btn-primary">Ver</button>
            </div>      
            
            <div class="col-5 col-sm-8">
            <strong class="text-gray-dark"><?php echo $list['titulo']; ?></strong>
            <span class="d-block">ID: <?php echo $list['id']; ?></span>        
            </div>

            <div class="col-6 col-sm-3 d-block">
                <div class="btn-group ">
                    <button data-lista-id="<?php echo $list['id']; ?>" class="btn btn-secondary btn-sm duplicar-lista">Duplicar</button>
                    <button data-lista-id="<?php echo $list['id']; ?>" class="btn btn-danger btn-sm excluir-lista">Excluir</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
 </div>


<form name="acoes" method="POST">
    <input type="hidden" name="route">
    <input type="hidden" name="id">
</form>
