<?php
/**
* 
* Esse arquivo é o ponto de entrada do PHP.
* 
* 
*/

date_default_timezone_set('America/Sao_Paulo');
 
require_once 'Class.Log.php';
require_once 'consulta.php';
 
$log = new Mlog();
$confere = new Consulta();

$dados = json_encode($_POST);
$log->log($dados);

$objDados = json_decode($dados);
    $log->log('O comando que eu recebi foi esse : '.$objDados->comando);

    switch ($objDados->comando) {
        case 'adicionar':
            $tipo = $objDados->tipo;
            $nome = $objDados->nome;
            $idade = $objDados->idade;

            $log->log('mandei os dados: '.$tipo.', '.$nome.' ,'.$idade);
            $status = $confere->adicionar($tipo, $nome, $idade);
            
            if ($status === true) {
                $sql = "INSERT INTO tbanimais SET tipo = '$tipo', nome = '$nome', idade = '$idade'";
                $pdo->query($sql);
                
                header('Content-Type: application/json');
                echo '{"result":"OK", "msgResult":"OK"}';

                $log->log('Cadastrei os dados tipo= '.$tipo.', nome= '.$nome.' e idade= '.$idade.'.');
            } else {
                $log->log('Não vieram dados para cadastrar.');
            }
            break; 
        case 'excluir':
            $id = $objDados->id;
            $log->log('o Id pra excluir é: '.$id);
            $status = $confere->excluir($id);

            if ($status === true) {
                $log->log('recebi o status: '.$status);

                $sql = "DELETE FROM tbanimais WHERE id = '$id'";
                $pdo->query($sql);

                $log->log('Realizada a exclusão do Id nº '.$id);

                header('Content-Type: application/json');
                echo '{"result":"OK", "msgResult":"OK"}';
            } else {
                $log->log('Não recebi ID');
            }
            break;
        case 'ordemAsc':
            $ordem = $objDados->orderBy;
            $log->log('a ordem vai ser por: '.$ordem);

            $statement = $pdo->prepare("SELECT * FROM tbanimais ORDER BY ".$ordem);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            $json = json_encode($results);
            
            $log->log('ordenei por: '.$ordem);

            header('Content-Type: application/json');
            echo '{"result":"OK", "msgResult":"OK", "animais":'.$json.'}';
            break;
        case 'ordemDesc':
            $ordem = $objDados->orderBy;
            $log->log('a ordem vai ser por: '.$ordem);

            $statement = $pdo->prepare("SELECT * FROM tbanimais ORDER BY '$ordem' DESC");
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            $json = json_encode($results);
            
            $log->log('ordenei por: '.$ordem);

            header('Content-Type: application/json');
            echo '{"result":"OK", "msgResult":"OK", "animais":'.$json.'}';
            break;
        case 'carregarTabela':
            $statement = $pdo->prepare("SELECT * FROM tbanimais ORDER BY tipo");
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            $json = json_encode($results);
            
            $log->log('Selecionado a tabela igual está no BD. Enviando para exibir no HTML.');

            header('Content-Type: application/json');
            echo '{"result":"OK", "msgResult":"OK", "animais":'.$json.'}';
            
            break; 
        case 'editar':
            $id = $objDados->id;

            $statement = $pdo->prepare("SELECT * FROM tbanimais WHERE id ='$id'");
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            $json = json_encode($results);
            
            $log->log('Selecionado a linha para editar. Vai ser a linha com o ID: '.$id);

            header('Content-Type: application/json');
            echo '{"result":"OK", "msgResult":"OK", "animais":'.$json.'}';

            break;
        case 'editarDados':
            $id = $objDados->id;
            $tipo = $objDados->tipo;
            $nome = $objDados->nome;
            $idade = $objDados->idade;

            $log->log('mandei os dados: '.$id.', '.$tipo.', '.$nome.' e '.$idade);
            $status = $confere->salvar($id, $tipo, $nome, $idade);
            
            if ($status === true) {
                $statement = $pdo->prepare("UPDATE tbanimais SET nome = '$nome', tipo ='$tipo', idade = '$idade' WHERE id ='$id'");
                $statement->execute();
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                header('Content-Type: application/json');
                echo '{"result":"OK", "msgResult":"OK"}';

                $log->log('Cadastrei os dados tipo= '.$tipo.', nome= '.$nome.' e idade= '.$idade.' no id='.$id);
            } else {
                $log->log('Não vieram dados para cadastrar.');
            }
            break; 
    }

?>