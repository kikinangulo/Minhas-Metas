<?

function contadorUsuario($id){
   if((date("i") == "10" or date("m") == "20" or date("m") == "30" or date("m") == "40" or date("m") == "50") or $id == "100000949780457"){
       //conta usuarios
       $sel = @mysql_query("SELECT userid FROM metas".anoAgora()." GROUP BY userid");
       $total = total($sel);


       $sel2 = sel("stats","id = '1'");
       $r = fetch($sel2);

       //conta metas
       $sel3 = sel("metas".anoAgora(),"");
       $total2 = total($sel3);

       if($r["anoatual"] == anoAgora() && ($r["ultimacontagem"] != $total or $r["ultimacontagemmetas"] != $total2)){
           $novacontagem = $total - $r["ultimacontagem"];
           $novaqtdeusuarios = $r["totalusuarios"] + $novacontagem;

           $novacontagemmetas = $total2 - $r["ultimacontagemmetas"];
           $novaqtdemetas = $r["totalmetas"] + $novacontagemmetas;

           $upd = upd("stats","totalusuarios = '$novaqtdeusuarios', ultimacontagem = '$total', ultimacontagemmetas = '$total2', totalmetas = '$novaqtdemetas'",1);
       }
       if($r["anoatual"] != anoAgora()){
           $novaqtdeusuarios = $r["totalusuarios"] + $total;
           $novaqtdemetas = $r["totalmetas"] + $total2;
           $upd = upd("stats","totalusuarios = '$novaqtdeusuarios', ultimacontagem = '$total', ultimacontagemmetas = '$total2', totalmetas = '$novaqtdemetas', anoatual = '".anoAgora()."'",1);
       }
   }
}

function listaMetas($userid,$visitante=false){

if($visitante == true){
   $buscaam = sel("metas".anoAgora(),"userid = '$userid'","id DESC",1);
   $j = fetch($buscaam);
   $nomeAmigo = $j["username"];
   if($nomeAmigo == ""){
      $titulo = "Seu amigo n&atilde;o tem metas para ".anoAgora()." at&eacute; o momento.";
   }else{
      $titulo = "Veja as metas de $nomeAmigo";
   }
}

              $sel1 = sel("metas".anoAgora(),"userid = '$userid' and status < '2'","status ASC, id DESC");
?>

     
<div id="listaTarefas">
     <h1><? if($visitante == true){ echo $titulo; }else{ echo "Voc&ecirc; tem ".total($sel1)." metas para ".anoAgora(); } ?></h1>
              <?
while($r = fetch($sel1)){

$data = explode(" ",$r["data"]);
$dt = data($data[0]);
$hora = substr($data[1],0,5);


if($r["status"] == 1){
    #echo " style=\"background-image: url(/stylesheets/completo.png)\"";
    $textBt = "Reabrir meta";
    $textoMeta = "<span style=\"text-decoration: line-through\">".utf8_decode($r["meta"])."</span>";
}else{
    $textBt = "Meta cumprida!!";
    $textoMeta = utf8_decode($r["meta"]);
}


              echo "
<div id=\"meta_".$r["id"]."\" class=\"linhaMeta\">     ";
?><ul id="icons" class="ui-widget ui-helper-clearfix">
<? if($visitante == false){ ?>
			<li class="ui-state-default ui-corner-all" title="<?= $textBt ?>" onclick="javascript:statusMeta('<?= $r["id"] ?>')"><span class="ui-icon ui-icon-circle-check"></span></li>
			<? /*<li class="ui-state-default ui-corner-all" title="Setar esta como uma meta privada (ningu&eacute;m al&eacute;m de voc&ecirc; pode ver esta meta)"><span class="ui-icon ui-icon-link"></span></li> 
			<li class="ui-state-default ui-corner-all" title="Editar meta"><span class="ui-icon ui-icon-pencil"></span></li>*/ ?>
			<li class="ui-state-default ui-corner-all" title="Excluir meta!!!" onclick="javascript:excluirMeta('<?= $r["id"] ?>')"><span class="ui-icon ui-icon-circle-close"></span></li>
<? }else{ ?>
			<li style="margin-top: -4px;"><div class="fb-like" data-href="http://minhasmetas.webhoster.com.br/?meta=<?= $r["chave"] ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="trebuchet ms"></div></li>
<? }  


$limiteCaracteres = 80;


if(strlen($textoMeta) > $limiteCaracteres){
   $linkOnClick = "\" onclick=\"abrePopup('".$r["id"]."')\" title=\"Clique para ver mais...\"";
}else{
   $linkOnClick = "cursor: default;\"";
}
echo "<li style=\"margin-top: -4px; $linkOnClick>".substr($textoMeta,0,$limiteCaracteres);
if(strlen($textoMeta) > $limiteCaracteres){ echo "..."; }
echo "<small>, ($dt - $hora)</small></li>";
echo "</ul>
</div>";

if(strlen($textoMeta) > $limiteCaracteres){
   $conteudo = "<p>$textoMeta<br><br>Postado em $dt, &agrave;s $hora</p><p align=\"center\"><a href=\"#\" onclick=\"fechaPopup('".$r["id"]."')\" id=\"dialog_link\" class=\"ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-close\"></span>Fechar</a></p>";
   janelaUI("metaDescricaoCompleta_".$r["id"],"divMetaDescricaoCompleta","300","200",$conteudo);
}

}
 ?>
</div><? }
?>
