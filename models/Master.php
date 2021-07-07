<?php
class master
{

    function __construct()
    {
        //SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
    }

    public function getInstance()
    {
        // $PDO = new PDO(
        //     'mysql:host=' . DB_Host . ';dbname=' . DB_Database,
        //     DB_User,
        //     DB_Pass
        // );
        // if ($PDO) {
        //     $this->setCon($PDO);
        //     $PDO = NULL;
        // } else {
        //     echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
        //     die;
        // }

        $this->CarregaPaginas();
    }


    // public function FechaConexao()
    // {
    //     if ($this->getCon()) {
    //         $this->con = NULL;
    //     }
    // }

    #funcao que seta a conexao no obj
    // public function setCon($con)
    // {
    //     $this->con = $con;
    // }

    // #funcao que retorna a conexao
    // public function getCon()
    // {
    //     return $this->con;
    // }

    public function setPagina($pagina)
    {
        $this->pagina = $pagina;
    }

    public function getPagina()
    {
        return $this->pagina;
    }

    public function setPaginaAux($pagina)
    {
        $this->paginaAux = $pagina;
    }

    public function getPaginaAux()
    {
        return $this->paginaAux;
    }

    #funcao que seta a conexao no obj
    public function setPaginaAdmin($pagina)
    {
        $this->paginaAdmin = $pagina;
    }

    #funcao que retorna a conexao
    public function getPaginaAdmin()
    {
        return $this->paginaAdmin;
    }

    #funcao imprime conteudo
    public function Imprime($conteudo)
    {
        //MODELO
        $header = $this->CarregaHtml('header');
        $footer = $this->CarregaHtml('footer');
        $conteudo = str_replace('<%HEADER%>', $header, $conteudo);
        $conteudo = str_replace('<%FOOTER%>', $footer, $conteudo);
        $conteudo = str_replace('<%URLPADRAO%>', UrlPadrao, $conteudo);
        // echo "teste";die;
        return $conteudo;
    }


    public function MontaHeaderComPermissao()
    {
    }

    public function MontaHeader()
    {
    }

    public function MontaCampoData()
    {
    }
    public function MontaSelectMeses()
    {
    }

    public function ListaNotificacao()
    {
    }

    #funcao que chama manutencao
    public function ChamaManutencao()
    {
        $SaidaHtml = $this->CarregaHtml('manutencao');
        echo $SaidaHtml;
        die;
    }

    #funcao que monta o conteudo
    public function MontaConteudo($banco)
    {

        // print_r($banco);die;
        #verifica se nao tem nada do lado da URLPADRAO
        if (!isset($banco->pagina)) {
            return $this->ChamaPhp('inicio');
            #verifica se a pagina existe e chama ela
        } elseif ($this->BuscaPagina($banco->pagina)) {
            return $this->ChamaPhp($banco->pagina);
            #Se nao tiver pagina chama 404
        } else {
            return $this->CarregaHtml('404');
        }
    }

    #Busca a pagina e verifica se existe
    public function BuscaPagina($pagina)
    {
    }

    #Fun��o que chama a pagina.php desejada.
    public function ChamaPhp($Nome)
    {
        session_start();
        if (strpos($Nome, '-') > 0) {
            $Nome = explode('-', $Nome);
            $Nome = ucfirst($Nome[0]) . ucfirst($Nome[1]);
        } else {
            $Nome = ucfirst($Nome);
        }

        @require_once('controllers/' . $Nome . 'Controller.php');
        return $Conteudo;
    }

    #Fun��o que monta o html da pagina
    public function CarregaHtml($Nome)
    {
        $filename = 'views/' . $Nome . ".html";
        $handle = fopen($filename, "r");
        $Html = fread($handle, filesize($filename));
        fclose($handle);
        return $Html;
    }

    #Fun��o que monta o Js da pagina
    public function CarregaJs($Nome)
    {
        $filename = 'static/tema/main/dist/js/pages/calendar/' . $Nome . ".js";
        $handle = fopen($filename, "r");
        $Html = fread($handle, filesize($filename));
        fclose($handle);
        return $Html;
    }

    #Funcao que redireciona para pagina solicitada
    public function RedirecionaPara($nome)
    {
        header("Location: " . UrlPadrao . $nome);
    }

    public function VerificaSessao()
    {
        session_start();
        if (isset($_SESSION['usuario_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function FechaSessao()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
    }

    public function DecimalToReal($valor)
    {
        $valor = number_format($valor, 2, ',', '.');
        return 'R$ ' . $valor;
    }

    public function RealToDecimal($valor)
    {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return $valor;
    }

    #Funcao que carrega as p�ginas
    public function CarregaPaginas()
    {
        $primeiraBol = true;
        $p = 0;
        $uri = $_SERVER["REQUEST_URI"];
        $exUrls = explode('/', $uri);
        $SizeUrls = count($exUrls) - 1;
        // print_r($exUrls);die;
        foreach ($exUrls as $chave => $valor) {
            if ($valor != '' && $valor != UrlDesenvolvimento && $valor != UrlDesenvolvimento2) {
                $valorUri = strip_tags(trim(addslashes($valor)));

                if ($primeiraBol) {
                    $this->setPagina($valorUri);
                    $primeiraBol = false;
                } else {
                    $paginaAux[$p] = $valorUri;
                    $p++;
                }
            }
        }

        if (isset($paginaAux)) {
            $this->setPaginaAux($paginaAux);
        }
    }

    public function utf8Fix($msg)
    {
        $accents = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
        $utf8 = array("á", "� ", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
        $fix = str_replace($utf8, $accents, $msg);
        return $fix;
    }

    public function MontaMensagem($cod_erro, $status_erro)
    {
        if ($status_erro == 'danger') {
            $class = "alert-danger";
            $titulo = "Alerta!";
        } elseif ($status_erro = "success") {
            $class = "alert-success";
            $titulo = "Perfeito!";
        } elseif ($status_erro = "info") {
            $class = "alert-info";
            $titulo = "Info!";
        } else {
            $class = "alert-warning";
            $titulo = "Aviso!";
        }

        $msg_erro =
            "<div class='alert " . $class . "'>
  					<strong>" . $titulo . "</strong> " . $cod_erro . "
				</div>";

        return $msg_erro;
    }

    public function FormataData($data)
    {
        $data = explode('-', $data);
        $data = $data[2] . '/' . $data[1] . '/' . $data[0];
        return $data;
    }

    public function FormataDataParaBanco($data)
    {
        $data = explode('/', $data);
        $data = $data[2] . '-' . $data[1] . '-' . $data[0];
        return $data;
    }
}
