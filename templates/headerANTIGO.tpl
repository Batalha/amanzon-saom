<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML/1.0 Transitional//EN">
<html>
    <head>
    
        <title>Sistema de apoio a O&M</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <link rel="stylesheet" type="text/css" href="libs/ext/resources/css/ext-all.css">
        

       	<link href="public/CSS/saom.css" rel="stylesheet" type="text/css">

        <link href="libs/jquery-ui-1.8.17/css/ui-lightness/jquery-ui-1.8.17.custom.css" rel="stylesheet" type="text/css">
        
        <link href="public/CSS/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <!-- <script src="libs/jquery.min.js"></script> -->
        <!-- <script src="libs/jquery-ui.min.js"></script> -->
        <script src="libs/jquery-ui-1.8.17/js/jquery-1.7.1.min.js"></script>
        <script src="libs/jquery-ui-1.8.17/js/jquery-ui-1.8.17.custom.min.js"></script>
        <script src="libs/jquery.form.js"></script>
        <script src="libs/jquery.columnfilters.js"></script>
        <script src="libs/jquery.ui.core.js"></script>
        <script src="libs/jquery.ui.position.js"></script>
        <script src="libs/jquery.ui.widget.js"></script>
        <script src="libs/jquery.meio.mask.js" charset="utf-8"></script>
        
        <script type="text/javascript" src="libs/ext/ext-all.js"></script>
        <script type="text/javascript" src="public/js/funcGlobals.js"></script>
        
        <!-- Sistema (Página Inicial) -->
        <script type="text/javascript" src="public/js/sistema.js"></script>
        <!-- Genéricos -->
        <script type="text/javascript" src="public/js/genericos.js"></script>
        <!-- Incidentes -->
        <script type="text/javascript" src="public/js/incidentes.js"></script>
        <link href="public/CSS/incidente.css" rel="stylesheet" type="text/css"/>
        <!-- Os -->
        <script type="text/javascript" src="public/js/os.js"></script>
        <link href="public/CSS/os.css" rel="stylesheet" type="text/css"/>
        <!-- agendamentos -->
        <script type="text/javascript" src="public/js/agendamentos.js"></script>
        <!-- instalacoes -->
        <script type="text/javascript" src="public/js/instalacoes.js"></script>
        <!-- equipamentos -->
        <script type="text/javascript" src="public/js/equipamentos.js"></script>
        
        <!-- acessibilidade -->
        <script type="text/javascript" src="public/js/acessibilidade.js"></script>
        <script type="text/javascript" src="public/js/autoComplete.js"></script>
        <script type="text/javascript" src="public/js/cronometros.js"></script>
        
        <!-- flexygrid -->
		<script src="libs/flexigrid-1.1/js/flexigrid.js"></script>
		<link href="libs/flexigrid-1.1/css/flexigrid.pack.css" rel="stylesheet" type="text/css"/>
		<link href="public/CSS/reparos_flexigrid.css" rel="stylesheet" type="text/css"/>
		
			<script src="public/js/flexigrid_reparos.js"></script>
			<script src="public/js/listos.js"></script>
			<script src="public/js/listAgendamentos.js"></script>
			<script src="public/js/listInstalacoes.js"></script>
			<script src="public/js/listMonitor.js"></script>
			<script src="public/js/listIncidentes.js"></script>
			<script src="public/js/incidentes/telefonemas.js"></script>
			<script src="public/js/listEquipamentos.js"></script>
			<script src="public/js/listchamadosfullCom.js"></script>
			<script src="public/js/listchamadosfullNoc.js"></script>
			<script src="public/js/listchamadosfullCampo.js"></script>
			<script src="public/js/listeutelsatcode.js"></script>
			<script src="public/js/listatendimentos.js"></script>
			<script src="public/js/listPreIncidentes.js"></script>
			<script src="public/js/listPreIncidentesNagios.js"></script>
			
		<!-- autocomplete -->
		<script type='text/javascript' src='libs/jquery-autocomplete/jquery.autocomplete.js'></script>
		<link rel="stylesheet" type="text/css" href="libs/jquery-autocomplete/jquery.autocomplete.css" />
		
		<!-- bootstrap twitter -->
		<script type='text/javascript' src='libs/bootstrap/js/bootstrap.js'></script>
		<link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.css" />
		
		<!-- hash listener -->
		<script type='text/javascript' src="public/js/hashlistener.js"></script>
		
		<!-- formautosave -->
		<script type='text/javascript' src="libs/formautosave/formautosave.js"></script>
		
		<!-- relatorio -->
		<script type='text/javascript' src="public/js/relatorio.js"></script>
		
		<!-- estilo de listagens -->
		<link href="public/CSS/listagens.css" rel="stylesheet" type="text/css">
		
		<!-- estilo de tabelas -->
		<link href="public/CSS/tabelas.css" rel="stylesheet" type="text/css">
		
		<!-- estilo de menu principal -->

		<link href="public/CSS/menu_principal.css" rel="stylesheet" type="text/css">

		
		<!-- estilo dos formulários do comissionamento -->
		<link href="public/CSS/comissionamento.css" rel="stylesheet" type="text/css">
		
		<!-- script para menu principal -->
		<script type='text/javascript' src="public/js/menu_principal.js"></script>
		
		<!-- script para home -->
		<script type='text/javascript' src="public/js/home.js"></script>
		
		<!-- script para compartilhamento -->
		<script type='text/javascript' src="public/js/compartilhamento.js"></script>
		
		<!-- script para home -->
		<script type='text/javascript' src="public/js/caixaEntradaHome.js"></script>
		
		<!-- script para submenus -->
		<script type='text/javascript' src="public/js/submenu.js"></script>

		<!-- Google maps -->
		<script type="text/javascript"
      		src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAgtv6Ypp45wfp5zw86ZafGGJWZyNezJus&sensor=true">
      		</script>
      	<script type='text/javascript' src="public/js/GoogleMaps.js"></script>
        
    </head>
    <body class="body" >
    
    	<input type="hidden" name="atualizacao" id="atualizacao" value="" />
    	<input type="hidden" name="ultimaRequisicao" id="ultimaRequisicao" value="" />
    
        <div id="todo">
		
        	<div id="topo">
				<div id="topoMeio">
					<div id="topoArea">

						<div id="logoTopo" style="width:280px;">
							<img src="../public/imagens/emc.png" alt=""/>
						</div>

						<div id="centro_topo">

							{if $login.perfis_idperfis == 4 || $login.perfis_idperfis == 5 || $login.perfis_idperfis == 2 ||$login.perfis_idperfis == 11}
								{include "centro_topo.tpl"}
							{else}
								<div id="localSaom" >{($SAOM == 'SP')?'São Paulo':'Prodemge' }</div>
							{/if}

						</div>

						<div id="cxLogin">

							<div id="mensagemBoasVindas">
								<label style="height:30px;">
									<span id="textoUsuarioConectado">Bem vindo,</span>
									<b>{$login.login}</b><span id="exclamacao">!</span>
								</label>
							</div>

						</div>

						<div style="float:left;width:50px;height:10px;">&nbsp;</div>

						<div style="height:0px;width:0px;clear:both;">&nbsp;</div>

					</div>


				</div>


            </div>
            
            <!-- <div id="menu" class="menu"> -->
            <div style="height:31px;">
	            <div id="MainMenu">
	            	<div id="menuCover"
	            		style="
	            		{if $login.perfis_idperfis == 4}
	            			width:960px;
	            		{else if $login.perfis_idperfis == 3}
	            			width:500px;
	            		{else if $login.perfis_idperfis == 5 && $login.subperfil_idsubperfil != 2}
	            			width:650px;
	            		{else if $login.perfis_idperfis == 5}
	            			width:780px;
	            		{else if $login.perfis_idperfis == 1}
	            			width:860px;
	            		{else if $login.perfis_idperfis==8 || $login.perfis_idperfis==9 || $login.perfis_idperfis==10}
	            			width:600px;
	            		{else}
	            			width:600px;
	            		{/if}"
	            	>
	                	{include file="menu_principal.tpl" title="menu_principal"}
	                </div>
	            </div>
            </div>
            
            <div id="conteudo" >