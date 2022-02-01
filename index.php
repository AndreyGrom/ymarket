<?
include_once 'config.php';
include_once 'yamarket.class.php';
$ym = new YMarket();
if (isset($get['code'])){
    $_SESSION['token'] = $ym->GetToken($client_id, $client_secret);
    file_put_contents('1.txt', $_SESSION['token'] . "\r\n", FILE_APPEND);
    Header("Location: ./");
}
$campaigns = array();
$offers = array();
if ($markets = $ym->GetMarkets($token, $client_id)){
    foreach ($markets->campaigns as $m){
        $campaigns[] = $m;
    }
}
if (isset($get['campaign_id'])){
    $offers = $ym->GetOffers($client_id, $client_secret, $get['campaign_id']);

}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="vendor/bootstrap.css">
    <title>Яндекс.Маркет</title>
    <style>

    </style>
</head>
<body>
<div class="container">
    <h2>Яндекс.Маркет</h2>
    <div class="row">
        <div class="col-sm-4">
            <?php if($client_id == '' || $client_secret == '') { ?>
                <p>Не настроены даные приложения</p>
            <?php } else { ?>
                <?if ($token != '') { ?>
                    <div class="alert alert-info">
                        <p>Ваш токен: <?php echo $token; ?></p>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        Токен не получен
                    </div>
                <?php } ?>
                <a class="btn btn-primary" href="https://oauth.yandex.ru/authorize?response_type=code&client_id=<?php echo $client_id; ?>">Запросить токен</a>
            <?php } ?>
        </div>
        <div class="col-sm-8">
            <?if ($campaigns) { ?>
                <table class="table table-hover">
                    <?php foreach ($campaigns as $s) { ?>
                        <tr>
                            <td><a href="?campaign_id=<?php echo $s->id; ?>"><?php echo $s->domain; ?></a></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-8">
            <?if ($offers) { ?>
                <table class="table table-hover">
                    <?php foreach ($offers as $s) { ?>
                        <tr>
                            <td><a href="?campaign_id=<?php echo $s->id; ?>"><?php echo $s->domain; ?></a></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
    </div>

</div>
</body>
</html>

