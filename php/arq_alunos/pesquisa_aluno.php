<?php
// Arquivo responsável por pesquisar e fazer as modificações necessárias no banco de dados

//Requerindo os arquivos
require "../funcoes.php";

// Chamando a função de conexão
$con = conectaDB();
if(!$con){echo "<p> Não houve conexão <br> </p>";	die(mysqli_error($con));}

// Mostrando os resultados da pesquisa do aluno
if(isset($_GET["nome"])){
    $nome = $_GET["nome"];
    $q   = "SELECT idaluno, aluno, turma FROM alunos_matriculados WHERE aluno LIKE '%$nome%'";
    $sel = executaQuery($con, $q);
    $c   = mysqli_num_rows($sel);
    if($c != 0){
        echo "<p> Selecione abaixo o nome </p>";
        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
        for($x = 0; $x < count($data); $x++){
            $aluno = $data[$x]["idaluno"];
            $valor = $data[$x]["aluno"] . " | " . $data[$x]["turma"];
            echo "<input type='radio' name='escolha' value='$aluno' id='$aluno' onchange='respondeChecked()'> <label for='$aluno'> $valor </label> <br>";
        }
    }else{echo "<p> Este nome não está registrado no banco de dados </p>";}
}

// Mostrando os dados do aluno
if(isset($_GET["idaluno"])){
    $id = $_GET["idaluno"];
    $q   = "SELECT idaluno, aluno, turma FROM alunos_matriculados WHERE idaluno = $id";
    $sel = executaQuery($con, $q);
    $c   = mysqli_num_rows($sel);
    if($c != 0){
        echo "<p> Mostrando os dados do aluno: </p>";
        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
        for($x = 0; $x < count($data); $x++){
            $aluno = $data[$x]["aluno"];
            $turma = $data[$x]["turma"];
              echo "<p> Nome: $aluno </p>";
              echo "<p> Turma: $turma </p>";
        }
    }

    // Fazendo a busca no banco de dados para registrar emprestimo ou devolução
    $q  = "SELECT MAX(idregistro), r.data, r.situacao, a.aluno, l.titulo, l.autor FROM regalunos as r JOIN alunos_matriculados as a ON r.idaluno = a.idaluno JOIN livros as l ON r.idlivro = l.idlivro WHERE r.idaluno = '$id' AND idregistro = (SELECT MAX(idregistro) FROM regalunos WHERE idaluno = '$id')";
    $sel  = executaQuery($con, $q);
    $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
    $situacao = $data[0]["situacao"];
    $idreg = $data[0]["MAX(idregistro)"];
    if($situacao === "e"){
        echo "<p> Há um livro emprestado </p>";
        echo "<ul>
                <li> Título: " . $data[0]["titulo"] . " </li>
                <li> Autor: " . $data[0]["autor"] . " </li>
              </ul>";
        // Caso tenha algum livro emprestado, registrar devolução
        echo "<button type='button' class='bt confirm' data-estado='emprestar' data-id='$id' data-idreg='$idreg' id='bt-reg' onclick='registrar(1)'> Registrar devolução </button>";
    }else{
        // Caso não tenha algum livro emprestado
        echo "<p> O aluno não possui livro emprestado </p>";
        echo "<label for='codbook'> Digite o nome do livro para registrar empréstimo </label>";
        echo "<input type='text' id='codbook' onkeyup='buscaLivro(this.value)'>";
        echo "<div id='recebeBusca'></div>";
        // echo "<button type='button' class='bt confirm' data-estado='devolver' data-id='$id' id='bt-reg' onclick='registrar(2)'> Registrar empréstimo </button>";
    }
}

// Fechando a conexão
fechaDB($con);
?>
