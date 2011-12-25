<?
include("crislib.php");

conexao();

$id = str($_POST["id"]);
if(empty($id)){
    error("Nenhuma meta sendo enviada...");
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

$busca = sel("metas".anoAgora(),"id = '$id'");
$h = fetch($busca);
$status = $h["status"];

if($status == 0){ $status = 1; }else{ $status = 0; }
$upd = upd("metas".anoAgora(),"status = '$status'",$id);

$data = explode(" ",$h["data"]);
$dt = data($data[0]);
$hora = substr($data[1],0,5);



if($status == 1){
    #echo " style=\"background-image: url(/stylesheets/completo.png)\"";
    $textBt = "Reabrir meta";
    $textoMeta = "<span style=\"text-decoration: line-through\">".utf8_decode($h["meta"]).", postado em $dt, &agrave;s $hora</span>";
}else{
    $textBt = "Meta cumprida!!";
    $textoMeta = utf8_decode($h["meta"]).", postado em $dt, &agrave;s $hora";
}



              echo "
<div id=\"meta_".$h["id"]."\" class=\"linhaMeta\">     ";
?><ul id="icons" class="ui-widget ui-helper-clearfix">
<? if($visitante == false){ ?>
			<li class="ui-state-default ui-corner-all" title="<?= $textBt ?>" onclick="javascript:statusMeta('<?= $h["id"] ?>')"><span class="ui-icon ui-icon-circle-check"></span></li>
			<li class="ui-state-default ui-corner-all" title="Setar esta como uma meta privada (ningu&eacute;m al&eacute;m de voc&ecirc; pode ver esta meta)"><span class="ui-icon ui-icon-link"></span></li>
			<li class="ui-state-default ui-corner-all" title="Editar meta"><span class="ui-icon ui-icon-pencil"></span></li>
			<li class="ui-state-default ui-corner-all" title="Excluir meta!!!"><span class="ui-icon ui-icon-circle-close"></span></li>
<? }else{ ?>
			<li style="margin-top: -4px;"><div class="fb-like" data-href="http://minhasmetas.webhoster.com.br/?meta=<?= $h["chave"] ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="trebuchet ms"></div></li>
<? }  
if(strlen($textoMeta) > 90){
   $linkOnClick = "\" onclick=\"abrePopup('".$h["id"]."')\" title=\"Clique para ver mais...\"";
}else{
   $linkOnClick = "cursor: default;\"";
}
echo "<li style=\"margin-top: -4px; $linkOnClick>".substr($textoMeta,0,90);
if(strlen($textoMeta) > 90){ echo "..."; }
echo "</li>";
echo "</ul>
</div>";
}
 ?>
</div>
<?
if(strlen($textoMeta) > 90){
$conteudo = "<p>$textoMeta<br><br>Postado em $dt, &agrave;s $hora</p><p align=\"center\"><a href=\"#\" onclick=\"fechaPopup('".$h["id"]."')\" id=\"dialog_link\" class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-close\"></span>Fechar</a></p>";
janelaUI("metaDescricaoCompleta_".$h["id"],"divMetaDescricaoCompleta","300","200",$conteudo);
}
?>