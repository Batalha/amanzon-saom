
<center>

<div style="width:794px;height:100%;padding:0;border:1px solid #000;">

	<!-- LOGO -->
		<div style="float:left;width:240px;height:45px;border-right:1px solid #000;border-bottom:1px solid #000;">
	    	<img src="public/imagens/logo_prodemge.jpg" />
	    </div>
	    <div style="float:left;width:550px;height:45px;text-align:center;font-size:30px;border-bottom:1px solid #000;">
	    	Termo de Aceite Técnico
	    </div>
	
    <!-- SOLICITANTE E DATA -->
	    <div style="float:left;width:587px;height:23px;text-align:left;padding-left:5px;border-right:1px solid #000;">
	    	Solicitante:{$obj.solicitante}
	    </div>
	    <div style="float:left;width:193px;padding-left:5px;">Data: {$obj.data}</div>
    
    <!-- INFORMACOES GERAIS -->
    	<!-- LINHA 1 -->
		    <div style="float:left;width:395px;border-right:1px solid #000;border-top:1px solid #000;padding-left:5px;">
		    	NOC/Operadora: {$obj.nocOperadora}
		    </div>
		    <div style="float:left;width:385px;padding-left:5px;border-top:1px solid #000;">
		    	Operadora/Cliente: {$obj.operadoraCliente}
		    </div>
	    <!-- LINHA 2 -->
		    <div style="float:left;width:395px;border-right:1px solid #000;border-top:1px solid #000;padding-left:5px;">
		    	GRE/PRODEMGE: {$obj.greProemge}
		    </div>
		    <div style="float:left;width:385px;padding-left:5px;border-top:1px solid #000;">
		    	Responsável/Cliente: {$obj.responsavelCliente}
		    </div>
    
    <!-- INFORMACOES TECNICAS -->
	    <div style="float:left;width:786px;border-top:1px solid #000;padding-left:5px;border-bottom:1px solid #000;">
	    	<div style="float:left;width:197px;border-right:1px solid #000;height:40px;text-align:center;">
	    		Consórcio<br/> {$obj.consorcio}
	    	</div>
	    	<div style="float:left;width:197px;text-align:center;border-right:1px solid #000;height:40px;">
	    		VSAT ID<br/>{$obj.vsatId}
	    	</div>
	    	<div style="float:left;width:191px;border-right:1px solid #000;height:40px;text-align:center;">
		    	Porta Kbps
		    </div>
	    	<div style="float:left;width:191px;text-align:center;">
		    	Plataforma<br/>{$obj.plataforma}
		    </div>
	    </div>
    
    <!-- GRAFICOS -->
    	<div style="height:1px !important;clear:both">&nbsp;</div>
    	
	    <div style="width:750px;margin:0 auto;padding-top:20px;text-align:center;">
	    	{if $obj.img1 != ''}<img src="{$obj.img1}" />{/if}
	    </div>
	    
	    <div style="width:750px;margin:0 auto;padding-top:20px;">
	    	{if $obj.img1 != ''}<img src="{$obj.img2}" />{/if}
	    </div>
    
</div>

</center>