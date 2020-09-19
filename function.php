<?php
$API_KEY_TOKEN = 'IBQTT7811MYYGPYU4NQ2RK7U6DQACAAJBG';

function cls()                                                                                                             
{
    print("\033[2J\033[;H");
}

function checkAddress(){
    $address = file('address.txt');
    print PHP_EOL.count(explode("\n",str_replace("\r", "", file_get_contents('address.txt'))))." address\n______________________________\n";
    foreach(explode(PHP_EOL, file_get_contents('address.txt')) as $value){
        $check = getAddress($value);
        if($check === 'OK'){
            echo 'LIVE|'.$value."\n";
        } elseif ($check === 'No transactions found'){
            echo 'DIE|'.$value."\n";
        }
    }
}

function checkBalance(){
    $address = file_get_contents('address.txt');
    print PHP_EOL.count(explode("\n",str_replace("\r", "", file_get_contents('address.txt'))))." address\n______________________________\n";
    $address = preg_replace('/\s+/',',',str_replace(array("\r\n","\r","\n"),' ',trim($address)));
    $check = getBalance($address);
    foreach($check as $result){
        if($result['balance'] === '0'){
            echo 'DIE|'.$result['account']."\n";
        } else {
            echo 'LIVE|'.$result['account']."  => balance=".$result['balance']."\n";
        }
    };
}

function getAddress($address) {
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

function getBalance($address){
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