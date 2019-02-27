<?php

include_once("./backupmysql.php");

include("/var/www/html/admin/index.php");

//Call the core function
backup_tables($dbhost, $dbuser, $dbpass, 'store', $tables);

backup_tables($dbhost, $dbuser, $dbpass, 'etnc', $tables);

$connection = ssh2_connect('home708280613.1and1-data.host', 22);
ssh2_auth_password($connection, 'u91141864', $dbpass);
  
  $redis = 'redis-backup'.time().'-'.date("dmy").'.rdb';
  $filesend = "/var/lib/redis/dump.rdb";
  $save = "./save/redis/".$redis;

ssh2_scp_send($connection, $filesend, $save); 
 
$apache = "/etc/apache2/apache2.conf";
 
$apache3 = 'apache-backup-'.'-'.date("dmy").'.conf';

$apache2 = "./save/apache2/".$apache3;

ssh2_scp_send($connection, $apache, $apache2);

$etherpad = "/var/www/html/vecchionet.com/etherpad-lite/settings.json";

$etherpad2 = "etherpad-backup-".time()."-".date("dmy").".json";

$etherpad3 = "./save/etherpad/".$etherpad2;

ssh2_scp_send($connection, $etherpad, $etherpad3);

?>
