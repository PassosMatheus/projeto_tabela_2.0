<?php
/**
 *  Classe para verificar as consultas e alterações do BD.
 */

require_once 'Class.Log.php';
require_once 'database.php';

class Consulta {

    /**
     * Função para verificar se recebeu dados nas strings $tipo, $nome e $idade e permitir que adicione os mesmos. 
     */
    public function adicionar($tipo, $nome, $idade) {
        $log = new Mlog();
        $log->log('Chegou na consulta para adicionar ! os dados recebidos foram: '.$tipo.' ,'.$nome.' e '.$idade);
        if (!empty($tipo) && !empty($nome) && !empty($idade)) {
            $log->log('Consegui verificar os dados, vou permitir que faça alteração no BD.');
            return true;
        } else {
            $log->log('ERRO: Dados vieram vazios.');
            return false;
        }
    }

    /**
     * Função para verificar se recebeu dados nas strings $tipo, $nome e $idade e permitir que edite os mesmos. 
     */
    public function editar($id, $tipo, $nome, $idade) {
        $log = new Mlog();
        $log->log('Chegou na consulta para editar ! os dados recebidos foram: '.$id.' ,'.$tipo.' ,'.$nome.' e '.$idade);
        if (!empty($id) && !empty($tipo) && !empty($nome) && !empty($idade)) {
            $log->log('Consegui verificar os dados, vou permitir que veja como estão cadastrados no BD.');
            return true;
        } else {
            $log->log('ERRO: Dados vieram vazios.');
            return false;
        }
    }

    /**
     * Função para verificar se recebeu dados na string $id para exclui-lo.
     */
    public function excluir($id) {
        $log = new Mlog();
        $log->log('Chegou na consulta de exclusão !');
        if (!empty($id)) {
            $log->log('recebi um ID, vou permitir que exclua.');
            return true;
        } else {
            $log->log('Não recebi o Id');
            return false;
        }
    }

    /**
     * Função para verificar se recebeu dados nas strings $id, $tipo, $nome e $idade e permitir que salve os mesmos.
     */
    public function salvar($id, $tipo, $nome, $idade) {
        $log = new Mlog();
        $log->log('Chegou na consulta para editar ! os dados recebidos foram: '.$tipo.' ,'.$nome.' e '.$idade.' do id='.$id);
        if (!empty($id) && !empty($tipo) && !empty($nome) && !empty($idade)) {
            $log->log('Consegui verificar os dados, vou permitir que faça alteração no BD.');
            return true;
        } else {
            $log->log('ERRO: Dados vieram vazios.');
            return false;
        }
    }
}
?>