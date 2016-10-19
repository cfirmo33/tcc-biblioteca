<?php
// Arquivo responsável por pesquisar e fazer as modificações necessárias no banco de dados

//Requerindo os arquivos
require "../funcoes.php";

// Chamando a função de conexão
$con = conectaDB();
if(!$con) {echo "<p> Não houve conexão <br> </p>";	die(mysqli_error($con));}

// Primeiro momento: o se pesquisará qual livro que está sendo emprestado
if(isset($_GET["idnaluno"])){
    $idnaluno = $_GET["idnaluno"];
    $idlivro = $_GET["idlivro"];
    $idreg   = $_GET["idreg"];
    $q = "SELECT nome FROM naoalunos WHERE idnaluno = $idnaluno";
    $sel = executaQuery($con, $q);
    if(mysqli_num_rows($sel) != 0){
        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
        echo "<p> Registrando devolução de " . $data[0]["nome"] . "</p>";
        echo "<p> Dados do empréstimo </p>";
        $q  = "SELECT r.idlivro, r.data, l.titulo, l.autor, r.prazo FROM regnaoalunos as r JOIN livros as l ON r.idlivro = l.idlivro WHERE idregistro = $idreg";
        $sel  = executaQuery($con, $q);
        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
        $dia = strtotime($data[0]["data"]);
        $dia = date("d-m-Y", $dia);
        $prazo = strtotime($data[0]["prazo"]);
        $prazo = date("d-m-Y", $prazo);
        echo "<p> Data: " . $dia . " </p>";
        echo "<p> Prazo: " . $prazo . " </p>";
        echo "<p> Título: " . $data[0]["titulo"] . " </p>";
        echo "<p> Autor: " . $data[0]["autor"] . " </p>";
        echo "<label for='selectDate'> Insira a data de devolução: </label>";
        echo "<input type='date' id='selectDate'>";
        echo "<button type='button' name='confirm' class='btn bt confirm' onclick='confirmaDevolucao()'> Confirmar Devolução </button>";
        echo "<div id='mostrarDadosLivro'></div>";
        }else{}
}else{}

if(isset($_GET["idnAluno"])){ // Fazer o registro da devolução e renovando o estoque
    $idnaluno = $_GET["idnAluno"];
    $livro = $_GET["idLivro"];
    $date = date("20y-m-d");
    // Registrando o empréstimo
    $q = "INSERT INTO regnaoalunos (data, situacao, idnaluno, idlivro) VALUES ('$date', 'd', '$idnaluno', '$livro')";
    $sel = executaQuery($con, $q);
    if($sel){
        // Pegando o nome do aluno
        $q = "SELECT nome FROM naoalunos WHERE idnaluno = $idnaluno";
        $sel = executaQuery($con, $q);
        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
        $nome = $data[0]["nome"];

        // Pegando o título do livro
        $q = "SELECT titulo FROM livros WHERE idlivro = $livro";
        $sel = executaQuery($con, $q);
        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
        $titulo = $data[0]["titulo"];

        // Mostrando que foi registrado
        echo "<p> Foi registrado a devolução do livro $titulo  a pessoa  $nome </p>";

        // Recuperando o estoque
        $q = "SELECT estoque FROM livros WHERE idlivro = $livro";
        $sel = executaQuery($con, $q);
        $data = mysqli_fetch_all($sel, MYSQLI_ASSOC);
        $est = $data[0]["estoque"];

        // Aumentando o estoque
        $q = "UPDATE livros SET estoque = $est+1 WHERE idlivro = $livro";
        $sel = executaQuery($con, $q);

        // Colocando o registro na tabela de registro de livros
        $q = "INSERT INTO reglivros (idreg, idlivro, data, situacao) VALUES (DEFAULT, $livro, '$date', 'd class='confirm'')";
        $sel = executaQuery($con, $q);
    }else{
        echo "<p> Não foi possivel registrar a devolução </p>";
    }
}

// Fechando a conexão
fechaDB($con);
?>
