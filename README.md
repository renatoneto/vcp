vcp (Vers�o 1.2)
===

Sistema de voto por pontos para ragnarok

Instala��o
===

Acesse install/index.php e preencha o formul�rio de instala��o, feito isso o sistema ir� criar toda a estrutura necess�ria para funcionamento.

Erros comuns
===

### Erro ao alterar a tabela login, verifique se o campo vcp_pontos j� n�o existe

R: A tabela vcp_pontos j� existe no seu banco de dados, voc� pode apaga-la e tentar instalar de novo, ou renomear o arquivo _inc_/config.php.default para _inc_/config.php e fazer as configura��es manualmente.

### Erro ao escrever arquivo de configura��o

R: Voc� n�o tem permiss�o de escrita na pasta _inc_/