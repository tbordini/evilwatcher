Evilwatcher - Monitoramento de domi­nios e hosts.
Autor: Thiago Bordini - thiago (at) bordini (dot) net
Versao - Stable 1.0

1 - Obter uma API key do WOT -> https://www.mywot.com/wiki/API
2 - Configurar as variaveis no arquivo db.inc.php.
3 - Criar o banco de dados no MySQL e restaurar o arquivo evilwatcher.sql para que sejam criadas as tabelas.
4 - Instalar o nmap (aptitude install nmap)
5 - Instalar o php-pear (aptitude install php-pear).
6 - Instalar os modulos pear Nmap e Whois (pear install Net_Nmap & pear install Net_Whois).
7 - Inserir no crontab os arquivos contidos na pasta cron com a periodicidade desejada.
