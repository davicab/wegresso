# Wegresso
Passo a passo de como instalar o projeto, configurar dominio e rodar a aplicação

# iniciar container - docker start container_name
# parar container - docker stop container_name
# reiniciar container - docker restart container_name
# remover container - docker rm container_name

# Iniciar Projeto - 

# 1 - clone esse repositorio na pasta workspace/www (workspace docker criado anteriormente)
# 2 - na raiz da pasta wegresso, crie um arquivo chamado .env e cole o conteudo do seguinte arquivo : https://drive.google.com/file/d/177bgtW9Plqmq5MKt8jkfzaTGw5NpxBga/view?usp=sharing

# 3 - via terminarl : 
    #iniciando todos os containers
    - docker start php_8_1 wks_node18 wks_php_8_1 db webserver
    
    #iniciando laravel
    - docker exec -it wks_php_8_1 bash
    - cd app/www/wegresso
    - composer install
    - exit
    
    # iniciando banco de dados
    - php artisan migrate
    
    # populando banco de dados com 15 usuarios aleatorio (se quiser mais, so rodar novamente)
    - php artisan db:seed --class=UserSeeder
    
    # instalando dependencias node
    - docker exec -it wks_node18 bash
    - cd app/www/wegresso
    - npm install
    - npm run build
    - exit
    
# Apos a instalacao, configure os hosts do seu computador para aceitar o "dominio" do projeto
    # linux
    - sudo nano /etc/hosts (vai abrir o terminal de edicao, navege por ele usando as setas do teclado)
    - abaixo da primeira linha do editor, escreva : 127.0.0.1      wegresso.local
    - CTRL + o (salvar o arquivo)
    - ENTER
    - CTRl + X
# Liberando permissões para alterar arquivos do projeto
    - cd workspace/projects/www/wegresso
    - sudo chmod 775 bootstrap/ &&\chmod 775 bootstrap/cache/ &&\chmod 775 storage/logs/ &&\chmod 775 storage/framework/views/ &&\chmod 775 storage/framework/testing/  &&\chmod 775 storage/framework/cache/
    - sudo chmod -R ugo+rw storage
