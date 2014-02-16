vcp (Versão 1.2)
===

Sistema de voto por pontos para ragnarok

Instalação
===

Acesse install/index.php e preencha o formulário de instalação, feito isso o sistema irá criar toda a estrutura necessária para funcionamento.

Erros comuns
===

### Erro ao alterar a tabela login, verifique se o campo vcp_pontos já não existe

R: A tabela vcp_pontos já existe no seu banco de dados, você pode apaga-la e tentar instalar de novo, ou renomear o arquivo _inc_/config.php.default para _inc_/config.php e fazer as configurações manualmente.

### Erro ao escrever arquivo de configuração

R: Você não tem permissão de escrita na pasta _inc_/