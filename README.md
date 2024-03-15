# Sobre o projeto
O projeto ele foi criado baseado no padrão monorepo, que consiste na idéia de armazenar um ou mais projetos no mesmo repositório. Com isso, tanto o projeto front-end (Aplicação) como também o projeto back-end (API) estão sendo armazenados nesse mesmo repositorio. 

Dessa forma é possível facilitar o processo de automação de build, visto que ambos os projetos que são dependentes estão centralizados no mesmo local. Porém por um outro lado, se o projeto expandir mais o repositório pode se tornar uma bagunça ou até mesmo exceder o limite de tamanho de armazenamento em situações menos comum, então é importante levantar todos os pontos sobre o projeto antes de definir a forma que serão armazenados.

Segue abaixo mais detalhes sobre o projeto:

- Back-end (API)
- Front-end (Aplicação)
- Docker(Containers de serviços utilizados na aplicação)


# Como Executar

Para inicializar o projeto, execute o script `start.sh`que consta no diretório principal do projeto. O script irá instalar as dependecias e inicializara os containers dos serviços utilizados.


Endereço Aplicação Front End:

`http://localhost:8001`

Endereço da API:

`http://localhost:8085`


Endereço da Documentação:

`http://localhost:8085/docs/index.html`

