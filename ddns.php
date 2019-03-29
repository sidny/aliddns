<?php
date_default_timezone_set('Asia/Shanghai');
if ($argc < 5 ) {
	echo "please info follow params:\n";
	echo "php ddns.php access_key access_secret domain subdomainlist";
	die();
}
$profile_name = 'cn-hangzhou'; //ecs节点位置
$access_key = $argv[1];
$access_secret = $argv[2];
$domain_name = $argv[3]; //要查询的域名
$effect_domain = explode(',',$argv[4]); //需要自动修改的子域名


include_once 'function.php';

while (true) {
	syncDdns();
	sleep(120);
}