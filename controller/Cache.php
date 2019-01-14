<?php

interface Cacce{
	public function read( $file );
	public function write( $file , $content );
}

class Cache implements Cacce
{
	protected $folder;
	protected $ext;
	 
	public function __construct( $folder = 'cache' , $ext = 'txt' )
	{
		$this->folder = $folder;
		$this->ext  = $ext;
	}
	
	public function getPathFileName( $key )
	{
		return sprintf('%s/%s.%s', $this->folder, md5($key), $this->ext);
	}
	 
	private function exists( $filename )
	{
		return file_exists( $filename );
	}
	 
	//metodo feito para criar ou nao arquivo de cache 
	public function isCache( $key )
	{
		$filename = $this->getPathFileName( $key );
		if( !$this->exists( $filename ) )
		{
			return true;
		}
		$filemtime = filemtime( $filename );
		if( time() > ($filemtime + (60 * $this->timeout)) )
		{
			return true;
		}
		return false;
	}
	 
	public function write( $key , $value )
	{
		$filename = $this->getPathFileName( $key );
		if( !file_put_contents( $filename , $value ) ){
			throw new CacheException(' Esse arquivo não foi possivel gravar algum valor :'.$key);
		}
	}
	 
	public function read($key){
		$filename = $this->getPathFileName($key);
		if($this->exists($filename)){
			if(!$result = file_get_contents($filename)){
				throw new CacheException(' Esse arquivo não foi possivel ler  :'.$key);
			}
			return $result;
		}
	}
}