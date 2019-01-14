<?php


/**
 * Description of DBincidente
 *
 * @author Daniel
 */
    include_once 'DBModel.php';

class DBMonitor extends DBModel {
   
        
    public function  __construct() {
        
        parent::__construct();    
    }
    
    public function init(){
        
        $arr = array('IMAIS-ROIS','IMAIS-NOTE','IMAIS-CORI_II','ITT-SJ-BOUS','ITT-SJ-FLNO','ITT-ITIS');
        $c = 0;
        foreach($arr as $i) {
          
            $sqlCount = "SELECT count(*) as total FROM monitor WHERE USERNAME LIKE '".$i."' AND LOGGED_ON LIKE 'N'";
            $dadosCount = $this->queryDados($sqlCount);
           
            if($dadosCount[0]['total']){
                
                $sqlAtual = "SELECT * FROM monitor WHERE USERNAME LIKE '".$i."' ORDER BY ID DESC LIMIT 1";
                $dadosAtual = $this->queryDados($sqlAtual);
                
                $dados[$c] = $dadosAtual[0];
                $dados[$c]['ALARME'] = 'LOGOFF';
                
                if($dadosAtual[0]['LOGGED_ON'] == 'Y') {
                    
                    $dados[$c]['STATUS'] = 'On';
                    $dados[$c]['COR'] = 'tdOrange';
                     
                }
                
                else {
                    
                    $dados[$c]['STATUS'] = 'Off';
                    $dados[$c]['COR'] = 'tdRed';
                }
                
                $sqlOff = "SELECT * FROM monitor WHERE USERNAME LIKE '".$i."' AND LOGGED_ON LIKE 'N'";
                $dadosOff = $this->queryDados($sqlOff);
                
                $length = $dados[$c]['NLOGOFF'] = count($dadosOff);
                $length--;
                
                $data1 = date('H:m:s d/m/Y',strtotime($dadosOff[0]['TIMESTAMP']));
                $data2 = date('H:m:s d/m/Y',strtotime($dadosOff[$length]['TIMESTAMP']));
                
                $dados[$c]['PERIOD'] = $data1." - ".$data2;
                $dados[$c]['CONTADOR'] = $this->calcMin($dadosOff[$length]['TIMESTAMP'], $dadosOff[0]['TIMESTAMP']);
            }
            
            $c++;
        }
        return $dados;
    }
    
    public function calcMin($dt1, $dt2) {

        $diff = round(abs(strtotime($dt1) - strtotime($dt2))/60);
        
        return $diff;
    }
}

?>
