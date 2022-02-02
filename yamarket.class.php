<?php
class YMarket{
    private $url;
    private $client_id;
    private $client_secret;
    public function GetToken($client_id, $client_secret){
        $query = array(
            'grant_type' => 'authorization_code',
            'code' => $_GET['code'],
            'client_id' => $client_id,
            'client_secret' => $client_secret
        );
        $query = http_build_query($query);
        $header = "Content-type: application/x-www-form-urlencoded";
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => $header,
                'content' => $query
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents('https://oauth.yandex.ru/token', false, $context);
        $result = json_decode($result);
        return $result->access_token;
    }

    public function GetMarkets($token, $client_id){
        $header = "Authorization: OAuth oauth_token=" . $token . ", oauth_client_id=" . $client_id;
        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'header'  => $header,
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents('https://api.partner.market.yandex.ru/v2/campaigns.json', false, $context);
        $result = json_decode($result);
        return $result ;
    }

    public function GetOffers($token, $client_id, $campaignId){
        $header = "Authorization: OAuth oauth_token=" . $token . ", oauth_client_id=" . $client_id;
        $opts = array('http' =>
            array(
                'method'  => 'GET',
                'header'  => $header,
            )
        );
        $context = stream_context_create($opts);
        //$result = file_get_contents('https://api.partner.market.yandex.ru/v2/campaigns/' . $campaignId .'/offers/all.json', false, $context);
        $result = file_get_contents('https://api.partner.market.yandex.ru/v2/campaigns/' . $campaignId .'/offers-mapping-entries/all.json', false, $context);
        $result = json_decode($result);
        return $result ;
    }
}
?>
