<?php
include_once 'aliyun-php-sdk-core/Config.php';
use Alidns\Request\V20150109 as Alidns;


function syncDdns() {
	$client = getAliDnsCllient();
	$records = getRecords($client);
	if(count($records)){
		$ip = getLocalIp();
		var_dump($ip);
		global $effect_domain,$domain_name;
		foreach ($records as $record){
			if(in_array( $record->RR,$effect_domain)){
				echo $record->RR.".$domain_name prepaire update  ( origin ip ".$record->Value.") \n" ;
				if($record->Value != $ip ){
					$res = updateRecord($client,$record,$ip);
					if($res->RequestId){
						echo $record->RR.".$domain_name is update to $ip ) \n";
					}
				}else {
					echo $record->RR.".$domain_name is no need for update \n" ;
				}
			} 
		}
	}
}
function getLocalIp(){
	$res = file_get_contents('http://2019.ip138.com/ic.asp');
	preg_match('/\d+\.\d+\.\d+\.\d+/',$res,$matches);
	return $matches[0];
}

function getAliDnsCllient(){
	global $profile_name,$access_key,$access_secret;
	$iClientProfile = DefaultProfile::getProfile($profile_name, $access_key,$access_secret);
	return new DefaultAcsClient($iClientProfile);
} 

function getRecords(&$client){
	global $domain_name;
	$request = new Alidns\DescribeDomainRecordsRequest();
	$request->setDomainName($domain_name);
	$request->setMethod("GET");
	$response = $client->getAcsResponse($request);
	return $response->DomainRecords->Record;
}


function updateRecord(&$client,$record,$ip){
	$request = new Alidns\UpdateDomainRecordRequest();
	$request->setRecordId($record->RecordId);
	$request->setRR($record->RR);
	$request->setType("A");
	$request->setValue($ip);
	$response = $client->getAcsResponse($request);
	return $response;
}


