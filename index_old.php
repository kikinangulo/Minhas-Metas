<?php

if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == "http" && $_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
  header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit();
}

require_once('FBUtils.php');
require_once('AppInfo.php');
require_once('utils.php');

$token = FBUtils::login(AppInfo::getHome());
if ($token) {

  $basic = FBUtils::fetchFromFBGraph("me?access_token=$token");
  $my_id = assertNumeric(idx($basic, 'id'));

  $app_id = AppInfo::appID();
  $app_info = FBUtils::fetchFromFBGraph("$app_id?access_token=$token");

  $likes = array_values(
    idx(FBUtils::fetchFromFBGraph("me/likes?access_token=$token&limit=4"), 'data')
  );

  $friends = array_values(
    idx(FBUtils::fetchFromFBGraph("me/friends?access_token=$token&limit=4"), 'data')
  );

  $photos = array_values(
    idx($raw = FBUtils::fetchFromFBGraph("me/photos?access_token=$token&limit=16"), 'data')
  );

  $app_using_friends = FBUtils::fql(
    "SELECT uid, name, is_app_user, pic_square FROM user WHERE uid in (SELECT uid2 FROM friend WHERE uid1 = me()) AND is_app_user = 1",
    $token
  );

  $encoded_home = urlencode(AppInfo::getHome());
  $redirect_url = $encoded_home . 'close.php';

  $send_url = "https://www.facebook.com/dialog/send?redirect_uri=$redirect_url&display=popup&app_id=$app_id&link=$encoded_home";
  $post_to_wall_url = "https://www.facebook.com/dialog/feed?redirect_uri=$redirect_url&display=popup&app_id=$app_id";
} else {
  exit("Invalid credentials");
}


date_default_timezone_set('America/Sao_Paulo');
#$m = new Mongo();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title><?php echo(idx($app_info, 'name')) ?></title>
    <link rel="stylesheet" href="stylesheets/screen.css" media="screen">
    <meta property="og:title" content=""/>
    <meta property="og:type" content=""/>
    <meta property="og:url" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:site_name" content=""/>
    <?php echo('<meta property="fb:app_id" content="' . AppInfo::appID() . '" />'); ?>
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


    <link type="text/css" href="css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    <style type="text/css">
            /*demo page css*/
            body{ font: 62.5% "Trebuchet MS", sans-serif; margin: 50px;}
            .demoHeaders { margin-top: 2em; }
            #dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
            #dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
            ul#icons {margin: 0; padding: 0;}
            ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
            ul#icons span.ui-icon {float: left; margin: 0 4px;}
            #dialog_link { font-size: 16px; }
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
      <p id="picture" style="background-image: url(https://graph.facebook.com/me/picture?type=normal&access_token=<?php echoEntity($token) ?>)"></p>

      <div>
        <h1>Bem vindo <strong><?php echo idx($basic, 'name'); ?></strong> // <?= $my_id ?></h1>
        <p class="tagline">
          Voc&ecirc; est&aacute; usando o aplicativo 
          <a href="<?php echo(idx($app_info, 'link'));?>"><?php echo(idx($app_info, 'name')); ?></a> desenvolvido por <a href="http://paico.com.br" target="_blank">paico</a>.
        </p>
      </div>
    </header>
    <section id="get-started">
        <p>Quais s&atilde;o as suas <span>metas</span> para este ano?</p>
        
        <input type="text" id="inputmetas" class="ui-state-default ui-corner-all"><br><br>
        <a href="#" id="dialog_link" class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-circle-check"></span>Adicionar na lista de <?= date("Y") ?></a>
        
    </section>

    <section id="samples" class="clearfix">
      <h1></h1>

      <div class="list">
        <h3>Suas metas para <?= date("Y") ?></h3>
        <ul class="things">

        </ul>
      </div>

      <div class="list">
        <h3>&nbsp;</h3>
        <ul class="things">

        </ul>
      </div>

      <div class="list">
        <h3>&nbsp;</h3>
        <ul class="things">

        </ul>
      </div>

      <div class="list">
        <h3>Amigos que usam este app</h3>
        <ul class="friends">
          <?php
            foreach ($app_using_friends as $auf) {
              // Extract the pieces of info we need from the requests above
              $uid = assertNumeric(idx($auf, 'uid'));
              $pic = idx($auf, 'pic_square');
              $name = idx($auf, 'name');
              echo('
                <li>
                  <a href="#" onclick="window.open(\'http://www.facebook.com/' .$uid . '\')">
                    <img src="https://graph.facebook.com/' . $uid . '/picture?type=square" alt="' . $name . '">
                    ' . $name . '
                  </a>
                </li>');
            }
          ?>
        </ul>
      </div>
    </section>

  </body>
</html>
