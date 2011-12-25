<?
include("crislib.php");

conexao();

$meta = str($_POST["id"]);
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

$ins = upd("metas".anoAgora(),"status = '9'",$meta);

info("Sua meta foi apagada!");
listaMetas($id);
?>
