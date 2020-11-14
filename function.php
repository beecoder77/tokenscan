<?php
$API_KEY_TOKEN = 'YourAPIToken';

function cls()                                                                                                             
{
    print("\033[2J\033[;H");
}

function checkAddressETH(){
    $address = file_get_contents('address.txt');
    print PHP_EOL.count(explode("\n",str_replace("\r", "", $address)))." address\n______________________________\n";
    foreach(explode(PHP_EOL, file_get_contents('address.txt')) as $value){
        $check = getAddressETH($value);
        if($check === 'OK'){
            fwrite(fopen("etherscan_wallet.txt", "a+"), 'LIVE|'.$value."\n");
            echo 'LIVE|'.$value."\n";
        } elseif ($check === 'No transactions found'){
            echo 'DIE|'.$value."\n";
        }
    }
}

function checkBalanceETH(){
    $address = file_get_contents('address.txt');
    print PHP_EOL.count(explode("\n",str_replace("\r", "", $address)))." address\n______________________________\n";
    $address = preg_replace('/\s+/',',',str_replace(array("\r\n","\r","\n"),' ',trim($address)));
    $check = getBalanceETH($address);
    foreach($check as $result){
        if($result['balance'] === '0'){
            echo 'DIE|'.$result['account']."\n";
        } else {
            $balance = $result['balance'] / 1000000000000000000;
            fwrite(fopen("etherscan_balance.txt", "a+"), 'LIVE|'.$result['account']."  => BALANCE = ".$balance."\n");
            echo 'LIVE|'.$result['account']."  => BALANCE = ".$balance."\n";
        }
    };
}

function getAddressETH($address) {
    global $API_KEY_TOKEN;
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.etherscan.io/api?module=account&action=txlistinternal&address=".$address."&startblock=0&endblock=2702578&sort=asc&apikey=".$API_KEY_TOKEN,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response, true);
    return $response['message'];
}

function getBalanceETH($address){
    global $API_KEY_TOKEN;
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.etherscan.io/api?module=account&action=balancemulti&address=".$address."&tag=latest&apikey=".$API_KEY_TOKEN,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response, true);
    return $response['result'];
}

function checkBalanceBSC(){
    $address = file_get_contents('address.txt');
    print PHP_EOL.count(explode("\n",str_replace("\r", "", $address)))." address\n______________________________\n";
    $address = explode("\n",$address);
    foreach($address as $address){
        $check = getBalanceBSC($address);
        if($check === 'Invalid address format'){
            echo 'DIE|ADDRESS NOT VALID = '.$address."\n";
        } elseif($check === '0'){
            echo 'DIE|'.$address.'|BALANCE = '.$check."\n";
        } else {
            $check = $check / 1000000000000000000;
            fwrite(fopen("bsc.txt", "a+"), 'LIVE|'.$address.'|BALANCE = '.$check."\n");
            echo 'LIVE|'.$address.'|BALANCE = '.$check."\n";
        }
    }
}

function getBalanceBSC($address){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.bscscan.com/api?module=account&action=tokenbalance&contractaddress=0x4247aeb8e759e575fe350921cd174c48df304f2a&address=".$address."&tag=latest",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $response = json_decode($response, true);
    return $response['result'];
}
