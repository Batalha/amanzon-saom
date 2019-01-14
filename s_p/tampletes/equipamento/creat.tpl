<div class="container1" style="width: 36%">
    <div class="row">
        {include file="s_p/tampletes/equipamento/submenu.tpl" title=submenu}
    </div>

</div>

<div class="row text-center" style="margin-top: 10px; color: red">
    <p><strong>Atenção:</strong> Seleciona primeiro o tipo de Equipamento para desbloqueio do Numero de Serie!</p>
</div>

<div class="container1" style=" width: 35%; margin-top: 5px;">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Cadastro de Equipamentos</div>
        </div>
        <div class="panel-body">
            <form action="Equipamento_sp/create" method="POST" id="fEqCreate" class="form" >

                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="input-group">
                                <span class="input-group-addon">
                                    <input type="radio" name="eq" id="cadMac"  value="1" onclick="javascript:checado(id)"/>
                                </span>
                            <input type="text" class="form-control" disabled="disabled" style="font-size: 13px;"  placeholder="Cadastrar MAC?">
                                <span class="input-group-addon">
                                    <input type="radio" name="eq"  id="cadOdu" disabled="disabled" value="0" checked onclick="javascript:checado(id)"/>
                                </span>
                            <input type="text" class="form-control" disabled="disabled" style="font-size: 14px;"  placeholder="Cadastrar ODU/BUC?">
                        </div>
                    </div>
                </div>

                <div class="row selecteOdu">
                    <div class="form-group col-md-12">
                        <label for="tipo_equipamentosOdu">Tipo de Equipamento</label>
                        <select class="form-control odu" name="tipo_equipamentos_sp_idtipo_equipamentos_sp" id="tipo_equipamentosOdu"
                                onchange="javascript:selecaoOdu()"
                        >
                            <option value=''>Escolha uma opção</option>
                            {foreach from=$listaTipoEquipamentos item=i}
                                {if $i.descricao == 'buc'}
                                    <option value='{$i.idtipo_equipamentos_sp}'>{$i.nome}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="row selecteModem" hidden>
                    <div class="form-group col-md-12">
                        <label for="tipo_equipamentosModem">Tipo de Equipamento</label>
                        <select class="form-control mac" name="tipo_equipamentos_sp_idtipo_equipamentos_sp" id="tipo_equipamentosModem" disabled="disabled"
                                onchange="javascript:selecaoModem()"
                        >
                            <option value=''>Escolha uma opção</option>
                            {foreach from=$listaTipoEquipamentos item=i}
                                {if $i.descricao == 'modem'}
                                    <option value='{$i.idtipo_equipamentos_sp}'>{$i.nome}</option>
                                {/if}
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="row" >
                    <div class="form-group col-md-12">
                    <label for="sno">Numero de Série</label>
                        <input class="form-control sno" type="text" name="sno" id="sno" readonly="readonly" placeholder="Numero de Série"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 esconder" hidden>
                    <label for="mac">MAC</label>
                        <input class="form-control"  type="text" alt="mac" name="mac" id="mac"  placeholder="MAC"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1">Disponível</option>
                            <option value="2">Em uso</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="observacoes">Obeservação</label>
                        <textarea class="form-control"  id="observacoes" name="observacoes" cols="30" placeholder="Obs"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="text-center">
                        <input type="button" class="btn btn-primary" value="Cadastrar Equipamento" onClick="javascript:sendPost('Equipamento_sp/create','fEqCreate')" />

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<br>
<br>
