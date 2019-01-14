<div class="container1" style="width: 36%">
    <div class="row">
        {include file="s_p/tampletes/equipamento/submenu.tpl" title=submenu}
    </div>

</div>
<div class="container1" style=" width: 30%; margin-top: 20px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Editar Equipamento</div>
        </div>
        <div class="panel-body">
            <form action="Equipamento_sp/edit" method="POST" id="fEqEdit" class="form" >
                <input type="hidden" name="idequipamentos_sp" id="idequipamentos_sp" value="{$obj.idequipamentos_sp}"/>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <label for="sno">Numero de Série</label>
                            <input class="form-control" type="text" name="sno" id="sno" value="{$obj.sno}" placeholder="Numero de Série"/>
                        </div>
                    </div>
                </div>
                {if $obj.mac == ''}

                {else}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <div class="">
                                <label for="mac">MAC</label>
                                 <input class="form-control"  type="text" alt="mac" name="mac" id="mac" value="{$obj.mac}" placeholder="MAC"/>
                            </div>
                        </div>
                    </div>
                {/if}
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <label for="status">Status</label>
                            <select class="form-control autosave_equipamento_sp" name="status" id="status"><!--  -->
                                <option value="1" {if $obj.status =='1'} selected {/if}>Disponível</option>
                                <option value="2" {if $obj.status =='2'} selected {/if}>Em uso</option>
                                <option value="3" {if $obj.status =='3'} selected {/if}>Com defeito</option>
                                <option value="4" {if $obj.status =='4'} selected {/if}>Cliente</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <label for="tipo_equipamentos_sp_idtipo_equipamentos_sp">Tipo de Equipamento</label>
                            <select class="form-control  autosave_equipamento_sp " name="tipo_equipamentos_sp_idtipo_equipamentos_sp" id="tipo_equipamentos_sp_idtipo_equipamentos_sp">
                                <option value=''>Escolha uma opção</option>
                                {foreach from=$lista_tipo_equipamento item=i}
                                    <option value='{$i.idtipo_equipamentos_sp}' {if $obj.tipo_equipamentos_sp_idtipo_equipamentos_sp == $i.idtipo_equipamentos_sp} selected {/if}>{$i.nome}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <label for="observacoes">Obeservação</label>
                            <textarea class="form-control"  id="observacoes" name="observacoes" cols="30" placeholder="Obs">{$obj.observacoes}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <input type="button" class="btn btn-primary" value="Atualizar" onClick="javascript:sendPost('Equipamento_sp/edit','fEqEdit')" />

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
<br>
