# WEgresso - Plataforma de Acompanhamento de Egressos do IF Goiano Campus Trindade

O objetivo central é desenvolver um sistema eficiente para coletar informações sobre a situação profissional dos egressos do IF Goiano, incluindo conquistas, desafios e mudanças de emprego. A ferramenta disponibilizará análises estatísticas, tais como taxas de conclusão de cursos, evolução na carreira e informações para orientar os egressos na tomada de decisões de carreira embasadas.

## Passo a Passo de Instalação e Configuração

### Iniciar Containers Docker
Para começar, inicie, pare, reinicie ou remova um container Docker usando os seguintes comandos:

- Iniciar container: `docker start container_name`
- Parar container: `docker stop container_name`
- Reiniciar container: `docker restart container_name`
- Remover container: `docker rm container_name`

### Iniciar o Projeto

1. Clone este repositório na pasta "workspace/www" (que foi criada previamente em seu ambiente Docker).
2. Na raiz da pasta "wegresso", crie um arquivo chamado `.env` e cole o conteúdo do seguinte arquivo: [Link para o .env](https://drive.google.com/file/d/177bgtW9Plqmq5MKt8jkfzaTGw5NpxBga/view?usp=sharing)

3. via terminarl : 
    ### iniciando todos os containers
    - docker start php_8_1 wks_node18 wks_php_8_1 db webserver
    
    ### iniciando laravel
    - docker exec -it wks_php_8_1 bash
    - cd app/www/wegresso
    - composer install
    - exit
    
    ### iniciando banco de dados
    - php artisan migrate
    
    ### populando banco de dados com 15 usuarios aleatorio (se quiser mais, so rodar novamente)
    - php artisan db:seed --class=UserSeeder
    
    ### instalando dependencias node
    - docker exec -it wks_node18 bash
    - cd app/www/wegresso
    - npm install
    - npm run build
    - exit
    
## Apos a instalacao, configure os hosts do seu computador para aceitar o "dominio" do projeto
- sudo nano /etc/hosts (vai abrir o terminal de edicao, navege por ele usando as setas do teclado)
- abaixo da primeira linha do editor, escreva : 127.0.0.1      wegresso.local
- CTRL + o (salvar o arquivo)
- ENTER
- CTRl + X
  
## Liberando permissões para alterar arquivos do projeto
- cd workspace/projects/www/wegresso
- sudo chmod 775 bootstrap/ &&\chmod 775 bootstrap/cache/ &&\chmod 775 storage/logs/ &&\chmod 775 storage/framework/views/ &&\chmod 775 storage/framework/testing/  &&\chmod 775 storage/framework/cache/
- sudo chmod -R ugo+rw storage
