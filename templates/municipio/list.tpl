<br>
<div class="container1">
    <div class="row">
        <div class="form-group">
            {include file="municipio/submenu.tpl" title=submenu}
        </div>
    </div>
</div>


<div class="container1" style="width: 60%;">
    <form action="Municipio/delete" id="formApagaMunicipio" name="formApagaMunicipio" method="POST" >
        <input type="hidden" name="idmunicipios" id="idmunicipios" value="{$obj.idmunicipios}" />
        <input type="hidden" name="municipio" id="municipio" value="{$obj.municipio}" />
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center">Municipios</div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="form-group">
                    <table class="table table-striped">
                        <thead>
                            <th>ID</th>
                            <th>Municípios</th>
                            <th>Macroregião</th>
                            <th>{if $login.perfis_idperfis != 3}Ação{/if}</th>

                        </thead>
                        <tbody>
                        {foreach from=$arr item=obj}
                            <tr>
                                <td>{$obj.idmunicipios}</td>
                                <td>{$obj.municipio}</td>
                                <td>{$obj.macroregiao}</td>
                                <td>
                                        <button type="button" class="btn-info" onclick="javascript:getAjaxForm('Municipio/view','conteudo',{ldelim}param:{$obj.idmunicipios},ajax:1{rdelim})">View</button>
                                    {if $login.perfis_idperfis != 3}
                                        <button type="button" class="btn-primary" onClick="javascript:getAjaxForm('Municipio/edit',false,{ldelim}param:{$obj.idmunicipios},ajax:1{rdelim})">Editar</button>
                                    {/if}
                                </td>
                            </tr>
                        {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        </form>
</div>

<br>

