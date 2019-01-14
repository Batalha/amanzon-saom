<?php

class CacheIncidentesModel
{
	protected $folder = "cache/";
	protected $incidenteListCacheArchive = "listaIncidentes";
	protected $incidenteDataCacheArchive = "dataIncidentes";
	protected $infoIncidentes = "infoIncidentes";
	
	private function trechoDeData(){}
	
	public function atualizaData( $page )
	{
		$dataNova = date('Y-m-d H:i:s');
		return $this->escreveEmArquivo( $this->incidenteDataCacheArchive , $dataNova , $page );
	}
	
	public function resgataDataCache( $page )
	{
		return $this->leArquivo( $this->incidenteDataCacheArchive , $page );
	}
	
	// metodos criados para primeira utilizacao de classe 
		public function verificaExistenciaCacheData( $page )
		{
			return file_exists( $this->folder . $this->incidenteDataCacheArchive . "_" . $page );
		}
	
	private function trechoDeCacheEmSi(){}
	
	public function verificaCache( $page )
	{
		return file_exists( $this->folder . $this->incidenteListCacheArchive . "_" . $page );
	}
	
	public function escreveCache($conteudo, $page)
	{
		$this->atualizaData($page);
			
		$escreveCache = $this->escreveEmArquivo($this->incidenteListCacheArchive, $conteudo, $page);
		if ($escreveCache) {
			$escreveInfoCache = $this->registraPaginaMontadaParaNovoIncidente($page);
		}
		
		return $escreveCache && $escreveInfoCache;
	}
	
	public function restagaCache( $page )
	{
		return $this->leArquivo( $this->incidenteListCacheArchive , $page );
	}
	
	private function trechoInfoIncidentes(){}
	
	// incidentes_novos
		public function verificaExistenciaDeIncidentesCriados( $page )
		{
			$infoArray = $this->resgataInfoIncidentes();
			return isset($infoArray['incidentes_novos_pgs']) && !in_array($page, $infoArray['incidentes_novos_pgs']);
		}
		
		public function insereNovoIncidente()
		{
			$infoArray = $this->resgataInfoIncidentes();
			$infoArray['incidentes_novos'] = 1;
			$infoArray['incidentes_novos_pgs'] = array();
			$info = json_encode($infoArray);
			$this->escreveEmArquivo( $this->infoIncidentes , $info );
		}
		
		public function registraPaginaMontadaParaNovoIncidente( $page )
		{
			$infoArray = $this->resgataInfoIncidentes();
			
			if ( isset($infoArray['incidentes_novos_pgs']) ) {
				array_push( $infoArray['incidentes_novos_pgs'] , $page );
			} else {
				$infoArray['incidentes_novos_pgs'] = array();
			}
				
			$info = json_encode($infoArray);
			return $this->escreveEmArquivo( $this->infoIncidentes , $info );
		}
		public function zeraIncidentesNovos()
		{
			$infoArray = $this->resgataInfoIncidentes();
			$infoArray['incidentes_novos'] = 0;
			$info = json_encode($infoArray);
			$this->escreveEmArquivo( $this->infoIncidentes , $info );
		}
	
	private function resgataInfoIncidentes()
	{
		$infosArray = array();
        if( $this->verificaExistenciaInfoIncidentes() )
        {
            $infos = $this->leArquivo( $this->infoIncidentes );
            $stdObject = json_decode( $infos );
            $infosArray = get_object_vars( $stdObject );
        }

        return $infosArray;
	}
	
	private function verificaExistenciaInfoIncidentes()
	{
		return file_exists( $this->folder . $this->infoIncidentes );
	}
	
	private function trechoMetodosGerais(){}
	
	private function escreveEmArquivo( $arquivo , $conteudo , $page = "" )
	{
		$arquivo = $this->folder . $arquivo;
		if (!empty($page)) {
		    $arquivo .= '_' . $page;
		}
		return file_put_contents($arquivo, $conteudo);
	}
	
	private function leArquivo($arquivo , $page = '')
	{
		$arquivo = $this->folder . $arquivo;
		if (!empty($page)) {
			$arquivo .= '_' . $page;
		}
		return file_get_contents($arquivo);
	}
}