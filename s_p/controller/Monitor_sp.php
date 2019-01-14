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
include_once 's_p/model/DBMonitor_sp.php';

class Monitor_sp extends Controller {
    
    protected $tplDir = 's_p/tampletes/monitor';
    
    function __construct()
    {
         
        parent::__construct();
        $this->DB = new DBMonitor_sp();
    }  
    
    public function index()
    {  
    	$arr = $this->DB->init();
		$this->smarty->assign('arr',$arr);
		$this->smarty->display("{$this->tplDir}/monitor.tpl");
		
    	//$this->smarty->display("{$this->tplDir}/monitor.tpl");
    }
    
    public function listeFonte()
    {
    	// Get posted data
			if (isset($_POST['page'])) 
			{
				$page = mysql_real_escape_string($_POST['page']);
			}
			if (isset($_POST['sortname'])) 
			{
			    $sortname = mysql_real_escape_string($_POST['sortname']);
			}
			if (isset($_POST['sortorder'])) 
			{
			    $sortorder = mysql_real_escape_string($_POST['sortorder']);
			}
			if (isset($_POST['qtype'])) 
			{
			    $qtype = mysql_real_escape_string($_POST['qtype']);
			}
			if (isset($_POST['query'])) 
			{
			    $query = mysql_real_escape_string($_POST['query']);
			}
			if (isset($_POST['rp'])) 
			{
			    $rp = mysql_real_escape_string($_POST['rp']);
			}
		
		// Setup sort and search SQL using posted data
			$sortSql = "order by $sortname $sortorder";
			$searchSql = ($qtype != '' && $query != '') ? "where $qtype LIKE '%$query%'" : '';
		
		// Get total count of records
			$sql = "select count(*)
					from monitor_sp
					{$searchSql}";
			$result = mysql_query($sql);
			$row = mysql_fetch_array($result);
			$total = $row[0];
		
		// Setup paging SQL
			$pageStart = ($page-1)*$rp;
			$limitSql = "limit $pageStart, $rp";
		
		// Return JSON data
			$data = array();
			$data['page'] = $page;
			$data['total'] = $total;
			$data['rows'] = array();
		
		$sql = "select *
				from monitor_sp
				{$searchSql}
				{$sortSql}
				{$limitSql}";
		$results = mysql_query($sql);
		
		while ($row = mysql_fetch_assoc($results)) 
		{
			$data['rows'][] = array(
				'id' => $row['id'],
				'cell' => array(
					$row['USERNAME'],
					$row['STATUS'], 
					$row['ALARME'], 
					$row['TIMESTAMP'],
					$row['PERIOD'],
					$row['CONTADOR'],
					$row['NLOGOFF']
					)
			);
		}
		//print_b($data,true);
		
		echo json_encode($data);
    }
}

?>