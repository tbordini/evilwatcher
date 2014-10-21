Evilwatcher - Monitoring malicious domains on the Internet in real time for forensics purposes. 
Autor: Thiago Bordini - rotiweb (at) hotmail (dot) com
Version - Stable 1.0.0

1 - Get your WOT Api key on -> https://www.mywot.com/wiki/API
2 - Config your variables in db.inc.php.
3 - Create database and tables structure from evilwatcher.sql
4 - Install nmap and php-pear(aptitude install nmap php-pear)
5 - Install Pear Nmap and Pear Whois modules (pear install Net_Nmap & pear install Net_Whois).
6 - Insert all files from the folder /cron in crontab tasks from all checks accord with example below
0,10,20,30,40,50 * * * * cd /var/www/evilwatcher/cron/ && php check.php
1,11,21,31,41,51 * * * * cd /var/www/evilwatcher/cron/ && php asn.php
2,12,22,32,42,52 * * * * cd /var/www/evilwatcher/cron/ && php nmap.php
@hourly cd /var/www/evilwatcher/cron/ && php full_nmap.php
