<?php 

class Mlog {

    public function log($log) {
            $retorno = file_put_contents(__DIR__ . '/animal.log', date("d/m/Y H:i:s")."-> ".$log."\n", FILE_APPEND);
            if ($retorno === false) {
                return false;
            }
            return true;
        }
}
?>