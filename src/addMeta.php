<?
include("crislib.php");

conexao();

$meta = str($_POST["meta"]);
if(empty($meta)){
    error("Voc&ecirc; n&atilde;o escreveu nada...");
    exit;
}

require '../facebook.php';
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
    //error_log($e);
    $user = null;
    error("Voc&ecirc; n&atilde;o est&aacute; logado!");
    exit;
  }
}
$id = $user_profile['id'];
$nome = $user_profile['name'];
$link = $user_profile['link'];

$chave = hash('sha512',date("YmdHis").'paico123#$');

$ins = ins("metas".anoAgora(),"chave, userid, username, userlink, meta, data", "'$chave', '$id', '$nome', '$link', '$meta', '".date("Y-m-d H:i:s")."'");

info("Sua meta foi adicionada!");
listaMetas($id);
?>