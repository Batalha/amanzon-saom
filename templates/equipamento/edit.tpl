<div class="container1">
    <div class="row">
        {include file="equipamento/submenu.tpl" title=submenu}
    </div>

</div>

<div class="row text-center" style="margin-top: 10px; color: red">
    <p>OBS: No Cadastro do Numero de serie do ODU/BUC, nao será preciso preencher o Campo do MAC...!</p>
</div>

<div class="container1" style=" width: 30%; margin-top: 5px;">
    <form action="Equipamento/edit" method="POST" id="fEqEdit" class="form" >
        <input type="hidden" name="idequipamentos" id="idequipamentos" value="{$obj.idequipamentos}"/>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Cadatro de Equipamentos</div>
            </div>
            <div class="panel-body">
                <form action="Equipamento/create" method="POST" id="fEqCreate" class="form" >
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input class="form-control" type="text" name="sno" id="sno" value="{$obj.sno}" placeholder="Numero de Série"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <input class="form-control"  type="text" alt="mac" name="mac" id="mac" value="{$obj.mac}" placeholder="MAC"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <select class="form-control"  name="status" id="status">
                                <option value="1" {if $obj.status == 1} selected {/if}>Disponível</option>
                                <option value="2" {if $obj.status == 2} selected {/if}>Em uso</option>
                                <option value="3" {if $obj.status == 3} selected {/if}>Com defeito</option>
                                <option value="4" {if $obj.status == 4} selected {/if}>Cliente</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <select class="form-control" name="tipo_equipamentos_idtipo_equipamentos" >
                                <option value=''>Escolha uma opção</option>
                                {foreach from=$lista_tipo_equipamento item=i}
                                    <option value='{$i.idtipo_equipamentos}' {if $obj.tipo_equipamentos_idtipo_equipamentos == $i.idtipo_equipamentos} selected {/if}>{$i.nome}</option>
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
                                    <option value="municipios.{$i.idmunicipios}" style="background:#ccc;"
                                            {if isset($obj.local.idmunicipios)}
                                                {if $obj.local.idmunicipios==$i.idmunicipios}
                                                    selected
                                                {/if}
                                            {/if}
                                    >{$i.municipio}</option>
                                {/foreach}

                                <optgroup LABEL="INSTALAÇÕES">INSTALAÇÕES</optgroup>
                                {foreach from=$listaInstalacoes item=i}
                                    <option value="instalacoes.{$i.idinstalacoes}" style="background:#B0B0FF;"
                                            {if isset($obj.local.idinstalacoes)}
                                                {if $obj.local.idinstalacoes==$i.idinstalacoes}
                                                    selected
                                                {/if}
                                            {/if}
                                    >{$i.nome}</option>
                                {/foreach}

                                <optgroup LABEL="OUTROS LOCAIS">OUTROS LOCAIS</optgroup>
                                {foreach from=$listaLocaisEquipamentos item=i}
                                    <option value="locais_equipamentos.{$i.idlocais_equipamentos}" style="background:#FFBCA6;"
                                            {if $obj.local.idlocais_equipamentos}
                                                {if $obj.local.idlocais_equipamentos==$i.idlocais_equipamentos}
                                                    selected
                                                {/if}
                                            {/if}
                                    >{$i.nome}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <textarea class="form-control"  id="observacoes" name="observacoes" cols="30" placeholder="Obs">{$obj.observacoes}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group text-center">
                            <input type="button" class="btn btn-primary" value="Atualizar" onClick="javascript:sendPost('Equipamento/edit','fEqEdit')" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </form>
</div>