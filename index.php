<?php
include('config/basic.php');
include('models/Master.php');
#Inicia Controle
$model_master = new master;
$model_master->getInstance();
// print_r($model_master);die;
$conteudo = $model_master->MontaConteudo($model_master);
// print_r($conteudo);die;
// echo $Conteudo;die;
$HTML = $model_master->Imprime($conteudo);
// $model_master->FechaConexao();
echo $HTML;