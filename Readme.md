# Lista R de compras

### Instalação

- Certifique-se de que você tenha o PHP instalado em seu ambiente de desenvolvimento. Você pode verificar a versão do PHP executando o comando php -v no terminal.

- Clone o repositório do projeto do GitHub:


      git clone https://github.com/seu-usuario/api-lista-compras-php.git



- Acesse o diretório do projeto:

      cd listaRdecompras


- Instale as dependências do projeto usando o Composer. Certifique-se de ter o Composer instalado em seu sistema. Se você não tiver o Composer, consulte a documentação oficial em https://getcomposer.org/.

      composer install

- Limpe os dados do banco de dados db/lista_compras.db ou remova para o sistema recriar a estrutura do banco de dados. Você pode usar qualquer ferramenta de gerenciamento de banco de dados de sua preferência.

- É necessário habilitar a extensão sqlite no arquivo php.ini antes de iniciar o servidor. Para isnto, basta localizar seu php.ini e descomentar a linha: 

      extension=sqlite3

- Inicie o servidor embutido do PHP:

      php -S localhost:8000 -t public

- Agora a API de lista de compras está em execução. Você pode fazer chamadas para http://localhost:8000 para interagir com a API.

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

- Os objetos JSON usados nas chamadas da API devem seguir a estrutura abaixo:

**Ver uma lista específica /api/?route=obter_lista&id=145**

![image](https://github.com/rogercgui/listaRdecompras/assets/20482054/93bbfee0-d329-4508-9254-8b25e04de3f7)



