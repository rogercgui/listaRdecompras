$(document).ready(function () {
    var listaId;

    // Cria nova lista
    $('#formCriarLista').submit(function (e) {
        e.preventDefault();
        var titulo = $('#titulo').val();
        $.ajax({
            url: 'api/?route=criar_lista',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ titulo: titulo }),
            success: function (response) {
                listaId = response.listaId;
                $('#formCriarLista').hide();
                $('#listaTitulo').text(titulo);
                $('#listaProdutos').show();
                carregarProdutos(listaId);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Modifica uma lista selecionada
    $(document).on("click", ".editar", function (e) {
        e.preventDefault();
        var listaId = $(this).data('id');
        $.ajax({
            url: 'api/?route=obter_lista&id=' + listaId,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                //listaId = response.produtos.listaId;
                titulo = response.lista.titulo;
                idLista = response.lista.id;
                $('#formCriarLista').hide();
                $('#listaTitulo').text(titulo);
                $('#idLista').val(idLista);
                $('#listaProdutos').show();
                carregarProdutos(listaId);
            },
            error: function () {
                $('.detalhes-container').html('<p>Ocorreu um erro ao carregar os detalhes da lista.</p>');
            }
        });
    });

    // Adiciona produtos em uma lista
    $('#formAdicionarProduto').submit(function (e) {
        e.preventDefault();
        var capturaIDLista = $('#idLista').val();
        if (capturaIDLista  === '') {
           // delete listaId
            console.log('O campo está vazio!');
        } else {
            listaId = capturaIDLista;
            console.log('Valor do campo:', listaId );
        }
        var nome = $('#nomeProduto').val();
        var quantidade = $('#quantidadeProduto').val();
        $.ajax({
            url: 'api/?route=adicionar_produto',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ listaId: listaId, nome: nome, quantidade: quantidade }),
            success: function (response) {
                carregarProdutos(listaId);
                //$('#listaId').val();
                $('#nomeProduto').val('');
                $('#quantidadeProduto').val('');
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Remove produtos de uma lista
    $(document).on('click', '.remover-produto', function () {
        var listaId = $(this).data('lista-id');
        var produtoId = $(this).data('produto-id');
        $.ajax({
            url: 'api/?route=remover_produto',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ produtoId: produtoId }),
            success: function (response) {
                carregarProdutos(listaId);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Aumenta o campo quantidade
    $(document).on('click', '.adicionar-quantidade', function () {
        var listaId = $(this).data('lista-id');
        var produtoId = $(this).data('produto-id');
        var quantidade = parseInt(prompt('Digite a quantidade a ser adicionada:', '1'));
        if (isNaN(quantidade)) {
            return;
        }
        $.ajax({
            url: 'api/?route=adicionar_quantidade',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ listaId: listaId, produtoId: produtoId, quantidade: quantidade }),
            success: function (response) {
                carregarProdutos(listaId);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    // Diminui valores do campo quantidade
    $(document).on('click', '.diminuir-quantidade', function () {
        var listaId = $(this).data('lista-id');
        var produtoId = $(this).data('produto-id');
        var quantidade = parseInt(prompt('Digite a quantidade a ser diminuída:', '1'));
        if (isNaN(quantidade)) {
            return;
        }
        $.ajax({
            url: 'api/?route=diminuir_quantidade',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ produtoId: produtoId, quantidade: quantidade }),
            success: function (response) {
                carregarProdutos(listaId);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Duplica lista durante a criação - 
    $('#formDuplicarLista').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'api/?route=duplicar_lista',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ listaId: listaId }),
            success: function (response) {
                var novaListaId = response.novaListaId;
                alert('Lista duplicada com sucesso! Nova Lista ID: ' + novaListaId);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    // Duplica lista a partir da lista de listas
    $(document).on("click", ".duplicar-lista", function (e) {
        e.preventDefault();
        var listaId = $(this).data('lista-id');
        $.ajax({
            url: 'api/?route=duplicar_lista',
            type: 'POST',
            dataType: 'json',
            data: JSON.stringify({ listaId: listaId }),
            success: function (response) {
                var novaListaId = response.novaListaId;
                alert('Lista duplicada com sucesso! Nova Lista ID: ' + novaListaId);
                location.reload();
                
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    // Excluir uma lista
    $(document).on('click', '.excluir-lista', function (e) {
        e.preventDefault();
        var listaId = $(this).data('lista-id');
        if (confirm('Tem certeza que deseja excluir esta lista?')) {
            $.ajax({
                url: 'api/?route=excluir_lista&id=' + listaId,
                type: 'POST',
                dataType: 'json',
                success: function (response) {
                        alert('Lista excluída com sucesso!');
                        location.reload();
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    });

    // Função que carrega as produtos de uma lista com seus respectivos botões
    function carregarProdutos(listaId) {
        $.ajax({
            url: 'api/?route=obter_lista&id=' + listaId,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var produtos = response.produtos;
                var lista = response.lista;
                $('#tabelaProdutos').empty();
                for (var i = 0; i < produtos.length; i++) {
                    var produto = produtos[i];
                    var row = '<tr>' +
                        '<td>' + produto.nome + '</td>' +
                        '<td>' + produto.quantidade + '</td>' +
                        '<td>' +
                        '<button class="btn btn-sm btn-danger remover-produto" data-lista-id="' + lista.id + '" data-produto-id="' + produto.id_prod + '">Remover</button> ' +
                        '<button class="btn btn-sm btn-primary adicionar-quantidade" data-lista-id="' + lista.id + '" data-produto-id="' + produto.id_prod + '">+</button> ' +
                        '<button class="btn btn-sm btn-primary diminuir-quantidade" data-lista-id="' + lista.id + '" data-produto-id="' + produto.id_prod + '">-</button>' +
                        '</td>' +
                        '</tr>';
                    $('#tabelaProdutos').append(row);
                }
                if (produtos.length > 0) {
                    $('#formDuplicarLista').show();
                } else {
                    $('#formDuplicarLista').hide();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
});

function enviaAcao(route, id) {
    document.acoes.route.value = route;
    document.acoes.id.value = id;
    document.acoes.submit();
}