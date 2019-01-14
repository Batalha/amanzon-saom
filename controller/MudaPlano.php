<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OS
 *
 * @author Daniel
 */
include_once 'model/DBMudaPlano.php';
include_once 'model/DBInstalacao.php';
include_once 'model/DBPlano.php';

class MudaPlano extends Controller {
    
    protected $tplDir = 'mudaplano';
    
    function __construct() {
        
        parent::__construct();
        $this->DB = new DBMudaPlano();
    }  
    
    
    public function create(){
       
       if (empty($this->dadosP['form'])) {
           
            if ( ! empty($this->dadosP['param'])) {
                
                    $DBInst = new DBInstalacao();
                    $DBPlan = new DBPlano();
                    
                    $DBInst->setPrkValue($this->dadosP['param']);
                    
                    $this->smarty->assign('obj',$DBInst->view());
                    $this->smarty->assign('planos',$DBPlan->liste());
            }
            $this->smarty->display("{$this->tplDir}/create.tpl");
       }
       else {
            
            $return  = $this->DB->create($this->dadosP['form']);
            
            if(count($return['erros'])) {
                
                $arrReturn['status'] = 'erro';
                $arrReturn['msg']    = implode("<hr>", $return['erros']);
            }
            else {
                
                $arrReturn['status']  = 'ok';
                $arrReturn['msg']     = 'Cadastro efetuado com sucesso!';
            }
            
            die_json($arrReturn);
       }
    }
    
     public function edit() {
        
        if ( ! empty($this->dadosP['param']) && empty($this->dadosP['form'])) {
                
            $this->DB->setPrkValue($this->dadosP['param']);
            
            $dados = $this->DB->view();
            
            $DBInst = new DBInstalacao();
            $DBPlan = new DBPlano();
            
            $this->smarty->assign('planos',$DBPlan->liste());
                    
            $this->smarty->assign('obj',$dados);
            $this->smarty->display("{$this->tplDir}/edit.tpl");
        }
        
        elseif ( ! empty($this->dadosP['form'])){
            
            $return  = $this->DB->edit($this->dadosP['form']);
            
            if(count($return['erros'])) {
                
                $arrReturn['status'] = 'erro';
                $arrReturn['msg']    = implode("<hr>", $return['erros']);
            }
            else {
                
                $arrReturn['status']  = 'ok';
                $arrReturn['msg']     = 'Edição realizada com sucesso!';
            }
            
            die_json($arrReturn);
        }
    }
    
}

?>