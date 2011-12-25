<?
include("src/crislib.php");



    conexao();

require 'facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId' => '146244962151403',
  'secret' => '6c47e00af335c0d354210ba6c716401b',
));

// Get User ID
$user = $facebook->getUser();


if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Minhas Metas</title>
    <link rel="stylesheet" href="stylesheets/screen.css" media="screen">
    <script>
      function popup(pageURL, title,w,h) {
        var left = (screen.width/2)-(w/2);
        var top = (screen.height/2)-(h/2);
        var targetWin = window.open(
          pageURL,
          title,
          'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left
          );
      }
    </script>

<script type="text/javascript" src="js/js.js"></script>
<?
if($user){
?>
<script type="text/javascript">
shortcut.add("Enter",function(){
    addMeta();
});
</script>
<? } ?>

    <link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="js/js.js"></script>
    <style type="text/css">
            /*demo page css*/
            body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
            .demoHeaders { margin-top: 2em; }
            #dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
            #dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
            ul#icons {margin: 0; padding: 0;}
            ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
            ul#icons span.ui-icon {float: left; margin: 0 4px;}
    </style>

    
    <!--[if IE]>
      <script>
        var tags = ['header', 'section'];
        while(tags.length)
          document.createElement(tags.pop());
      </script>
    <![endif]-->
  </head>
  <body>
    <header class="clearfix">
      <? if($user){ ?> <p id="picture" style="background-image: url(https://graph.facebook.com/<?= $user ?>/picture"></p><? } ?>

      <div>
        <h1><? if($user){ ?>Bem vindo <strong><?= $user_profile['name'] ?></strong><? }else{ ?>Para usar este aplicativo voc&ecirc; precisa se logar no Facebook. Clique no bot&atilde;o abaixo para entrar:<? } ?></h1>
        <p class="tagline">
          Voc&ecirc; est&aacute; usando o aplicativo 
          <a href="http://minhasmetas.webhoster.com.br">Minhas Metas</a> desenvolvido por <a href="http://paico.com.br" target="_blank">paico</a>.
        </p>
      </div>
    </header>
    <section id="get-started">
        <? if($user){ ?><p>Quais s&atilde;o as suas <span>metas</span> para <span><?= anoAgora() ?></span>?</p>
        
        <input type="text" id="inputmetas" class="ui-state-default ui-corner-all"><br><br>
        <a href="#" onclick="addMeta()" id="dialog_link" class="ui-state-default ui-corner-all" style="font-size: 16px;"><span class="ui-icon ui-icon-circle-plus"></span>Adicionar na lista de <?= anoAgora() ?></a>
        <? }else{ ?>
<div style="margin-top: 25px;"><a href="<?php echo $loginUrl; ?>" id="dialog_link" class="ui-state-default ui-corner-all" style="font-size: 18px;"><span class="ui-icon ui-icon-circle-plus"></span> Entre com seu Facebook para usar o Minhas Metas</a></div>
<? } ?>
    </section>

    <section id="samples" class="clearfix"><? if($user){ ?>
<?
if($_GET["meta"] != ""){
   $sel33 = sel("metas".anoAgora(),"chave = '".str($_GET["meta"])."'");
   $p = fetch($sel33);
   ?>      <h1>Uma das metas de <a href="<?= $p["userlink"] ?>" target="_blank"><?= $p["username"] ?></a></h1>

     
<div id="listaTarefas">
      <div id="metaUnica"><?= $p["meta"] ?></div>
      <p>Veja mais metas deste usu&aacute;rio <a href="/<?= $p["userid"] ?>">aqui</a>.</p>
</div>
<?
}else{

   if($_GET["i"] != ""){
      $idUSUARIO = str($_GET["i"]);
      listaMetas($idUSUARIO,1);
   }else{
      $idUSUARIO = $user_profile['id'];
      listaMetas($idUSUARIO);
   }

}
}
?>

    </section>

<? 
//print_r($user_profile);
?>


  </body>
</html>
