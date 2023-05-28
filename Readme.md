# Lista R de compras




|Método|Endpoint|Descrição|
|-|-|-|
|GET | api/? route = obter_lista & id={listaId}|Retorna os dados de uma lista|
|GET| api/? route = obter_listas|Restorna a lista de listas|
|POST| api/?route=criar_lista|Cria uma nova lista|
|POST| api/?route=adicionar_produto|Adiciona um produto|
|POST| api/?route=remover_produto|Remove um produto|
|POST| api/?route=adicionar_quantidade|Adiciona quantidade ao produto|
|POST| api/?route=diminuir_quantidade|Reduz quantidade do produto|
|POST| api/?route=duplicar_lista|Duplica uma lista|
|POST| api/?route=excluir_lista&id={listaId}|Exclui uma lista|