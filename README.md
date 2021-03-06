# PSI_PlatSI

# Descrição do projeto

No âmbito da unidade curricular de Plataformas de Sistemas de Informação do 3º Semestre do Curso TeSP de Programação de Sistemas de Informação do Instituto Politécnico de Leiria, foi criada a aplicação WEB (Front-end e Back-end) pertencente ao projeto “CicloDias”, que consiste na elaboração de uma aplicação que monitoriza a atividade física do utilizador.

O projeto é comum entre várias disciplinas, mas as fases que traçam este projeto são divididas entre todas, conforme a sua pertinência.

## Membros da Equipa

* Iuri Carrasqueiro Nº 2201127
* Gabriel Silva Nº 2201133

# Preparar a aplicação

## Ver Notas Adicionais antes de começar a preparação da aplicação

## Criar a base de dados e tabelas

Executar o ficheiro SQL "CriarDB"

## Na pasta APP executar os comandos seguintes:

.\yii migrate --migrationPath=@yii/rbac/migrations

.\yii migrate

# Criar as tabelas da aplicação

Executar o ficheiro SQL "CriarTabelas"

# Criar os utilizadores e inserir os dados padrão

Executar o ficheiro SQL "Dados"

## Com estes passos a aplicação estará pronta a utilizar

# Credenciais de Acesso

## Administrador

Username: admin

Password: adminadmin

## Moderador

Username: moderador

Password: 123456789

## Utilizador

Username: test

Password: 123456789

# Notas

## Caso seja uma instalação limpa adicionar esta linha no ficheiro common/config/main-local.php

'dsn' => 'mysql:host=127.0.0.1;dbname=projectdb',

## Configurar o nome de utilizador e a palavra-passe caso não seja a padrão - ficheiro common/config/main-local.php

# Imagem da instituição

![IPL](docs/logoipl.png)