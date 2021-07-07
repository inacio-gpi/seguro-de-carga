<?php
#include das funcoes da tela inico
include('models/Inicio.php');
include('models/Contato.php');
include('models/Cliente.php');

#Instancia o objeto
$model_inicio = new inicio();

$Conteudo = $model_inicio->CarregaHtml('inicio');

$Conteudo = str_replace("<%MSG%>", $msg, $Conteudo);
