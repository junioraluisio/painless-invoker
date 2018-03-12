# README

Invoker estabelece as classes do instalador do Painless, além de prover um maker de arquivos padrões para um software RESTFul.

## Terminal
O Invoker possui um maker que permite ser executado via terminal para escrita de classes, actions, routes, middlewares, além de um arquivo index e htaccess padrões que permite a utilização do sistema de rotas do PHP Slim e o gerenciador de templates do Twig.

##### Comandos
>php invoker [actions | classes | routes | htaccess | index | middleware] [empty | table:<table_name> | name:<name>]

_**Classes**_:
> php invoker classes table:<table_name>

_**Actions**_:
> php invoker actions table:<table_name>

_**Routes**_:
> php invoker routes table:<table_name>
  
_**Middlewares**_
> php invoker middleware name:<middleware_name>

_**Arquivo  .htaccess**_:  
> php invoker htaccess
  
_**Arquivo index.php**_
> php invoker index

## Formação de um link Dashboard
Os links utilizam os verbos HTTP para identificar quais actions serão executadas.

[**POST**]   - inserção de novos registros.  
[**PUT**]    - atualização de registros com base em um ID.  
[**PATCH**]  - alterar um registro para "habilitado" com base em um ID.  
[**DELETE**] - alterar um registro para "desabilitado" com base em um ID.

##### Modelo do link
_http://[dominio]/[target]/[id|empty]_

>_Para mais informações de formação de links para aplicativos RESTFul leia: [Using HTTP Methods for RESTful Services](http://www.restapitutorial.com/lessons/httpmethods.html)._
