
<div class="container1">
    <div class="row">
        {include file="equipamento/submenu.tpl" title=submenu}
    </div>
</div>

<div class="row text-center" style="margin-top: 10px; color: red">
    <p>OBS: No Cadastro do Numero de serie do ODU/BUC, nao será preciso preencher o Campo do MAC...!</p>
</div>

<div class="container1" style=" width: 30%; margin-top: 5px;">
    <form action="Equipamento/create" method="POST" id="fEqCreate" class="form" >
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadatro de Equipamentos</div>
        </div>
        <div class="panel-body">
            <form action="Equipamento/create" method="POST" id="fEqCreate" class="form" >
                <div class="row">
                    <div class="form-group col-md-12">
                        <input class="form-control" type="text" name="sno" id="sno" placeholder="Numero de Série"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <input class="form-control"  type="text" alt="mac" name="mac" id="mac" placeholder="MAC"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <select class="form-control" name="status" id="status">
                            <option value="1">Disponível</option>
                            <option value="2">Em uso</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <select class="form-control" name="tipo_equipamentos_idtipo_equipamentos" >
                            <option value=''}>Escolha uma opção</option>
                            {foreach from=$listaTipoEquipamentos item=i}
                                <option value='{$i.idtipo_equipamentos}'>{$i.nome}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <select class="form-control" name="local" id="local">
                            <option></option>
                            <optgroup LABEL="MUNICÍPIOS">MUNICÍPIOS</optgroup>
                            {foreach from=$listaMunicipios item=i}
                                <option value="municipios.{$i.idmunicipios}" style="background:#ccc;">{$i.municipio}</option>
                            {/foreach}

                            <optgroup LABEL="INSTALAÇÕES">INSTALAÇÕES</optgroup>
                            {foreach from=$listaInstalacoes item=i}
                                <option value="instalacoes.{$i.idinstalacoes}" style="background:#B0B0FF;">{$i.nome}</option>
                            {/foreach}

                            <optgroup LABEL="OUTROS LOCAIS">OUTROS LOCAIS</optgroup>
                            {foreach from=$listaLocaisEquipamentos item=i}
                                <option value="locais_equipamentos.{$i.idlocais_equipamentos}" style="background:#FFBCA6;">{$i.nome}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control"  id="observacoes" name="observacoes" cols="30" placeholder="Obs"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary" value="" onClick="javascript:sendPost('Equipamento/create','fEqCreate')">Enviar</button>

                    </div>
                </div>
            </form>
        </div>
    </div>
    </form>
</div>
<br>
<br>
<br>
