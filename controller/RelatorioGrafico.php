<?php

interface RelatorioFotograficoInterface
{
	public function view();
	
	public function upload();
	
	public function update();
}

class RelatorioFotografico extends Controller implements RelatorioFotograficoInterface
{
	protected $tplDir = 'relatoriofotografico';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function view()
	{
		// TODO: busca dados necessários para apresentacao no form
		// TODO: filtra pra condicionais de aprovacao ou não
		// TODO: filtra o que vai ser mostrado pelo perfil logado
		
		//$this->smarty->display("{$this->tplDir}/.tpl");
	}
	
	public function upload()
	{
		// TODO: valida arquivo
		// TODO: atualiza nome arquivo
		// TODO: upload arquivo
		// TODO: registra arquivo
	}
	
	public function update()
	{
		// TODO: usuario aprova ou nao, e faz ou não comentário
	}
	
}