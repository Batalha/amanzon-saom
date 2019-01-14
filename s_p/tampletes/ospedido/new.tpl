
	<div class="container1" style="margin-top: -10px; margin-left: 7%;">
		<div class="row">
			{include file="s_p/tampletes/ospedido/submenu.tpl" title=submenu}
		</div>
	</div>
	<br>



	<div class="container1" style="width: 40%;">
        <form action="OsPedido/create" method="POST" id="FPOSCreate" class="form">
            <input type="hidden" name="iduser_cadastro" value="{$login.idusuarios}">
            <input type="hidden" name="empresas_idempresas" value="{$login.empresas_idempresas}">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="pane-title text-center">Pedido e Solicitacão de OS</div>
				</div>
				<div class="panel-body">
					<div class="row">
                        <div class="form-group col-md-12">
                            <label for="cliente_final">Cliente</label>
                            <input class="form-control" type="text" name="cliente_final" id="cliente_final">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="local">Local da Instalação</label>
                            <input class="form-control" type="text" name="local" id="local">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-1">
                            <label for="">Lat</label>
                        </div>
                        <div class="form-group col-md-1">
                            <div class="">
                                <input class="form-control" type="text"  maxlength="2"  name="lat_graus" id="lat_graus" value="" placeholder="º"/>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <div class="">
                                <input class="form-control" type="text"  maxlength="2" name="lat_minutos" id="lat_minutos" value="" placeholder='"'/>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <input class="form-control" type="text"  maxlength="2" name="lat_segundos" id="lat_segundos" value="" placeholder="'" />
                        </div>
                        <div class="form-group col-md-2">
                            <select class="form-control" size="1" name="lat_direcao" id="lat_direcao">
                                <option value="S" {if $obj.latitude_direcao=='S'}selected{/if}>S</option>
                                <option value="N" {if $obj.latitude_direcao=='N'}selected{/if}>N</option>
                            </select>
                        </div>
                        <div class="form-group col-md-1">
                            <label for="">Long</label>
                        </div>
                        <div class="form-group col-md-1">
                            <div class="">
                                <input class="form-control" type="text"  maxlength="2"  name="lon_graus" id="lon_graus" value="" placeholder="º"/>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <div class="">
                                <input class="form-control" type="text"  maxlength="2" name="lon_minutos" id="lon_minutos" value="" placeholder='"'/>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <input class="form-control" type="text"  maxlength="2" name="lon_segundos" id="lon_segundos" value="" placeholder="'" />
                        </div>
                        <div class="form-group col-md-2">
                            <select class="form-control" size="1" name="lon_direcao" id="lon_direcao">
                                <option value="S" {if $obj.longitude_direcao=='S'}selected{/if}>S</option>
                                <option value="N" {if $obj.longitude_direcao=='N'}selected{/if}>N</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <select  name="canal_venda_idcanal_venda" id="canal_venda_idcanal_venda" class="form-control inputReq">
                                <option value="">	-- Planos --</option>
                                {foreach from=$listaCanalVendas item=vez}
                                <option value="{$vez.idcanal_venda}">{$vez.plano} - {$vez.servico}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <select name="fator_comp" id="fator_comp" class="form-control inputReq">
                                <option value=""> -- Fator de Compartilhamento -- </option>
                                <option value="fc15">FC = 1:5</option>
                                <option value="fc110">FC = 1:10</option>
                                <option value="fc120">FC = 1:20</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input class="btn btn-primary" type="button" value="Cadastrar Pedido OS" onClick="javascript:sendPost('OsPedido/create','FPOSCreate')" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 text-center">
                            <b style="font-size: 11px;"><font color="red">*</font> Todos os campos são obrigatório </b>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
