<br>
<div class="container1">
    <div class="row">
        <div class="form-group">
            {include file="usuario/submenu.tpl" title=submenu}
        </div>
    </div>
</div>

<div class="container1" style="width: 50%">
    <form action="Usuario/create" method="POST" id="fUsCreate" class="form" >

    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title text-center" align="center">Usuário</div>
        </div>
        <div class="panel-body">
            <table class="table table-bordered ">
                <tr>
                    <td style="text-align:right;">
                        <label for="nome">Nome</label>
                    </td>
                    <td>
                        {$obj.nome}
                    </td>
                    <td style="text-align:right;">
                        <label for="incidentes">Pode ser responsável por incidente?</label>
                    </td>
                    <td>
                        {if $obj.incidentes==1}Sim{else}Não{/if}
                    </td>
                </tr>

                <tr>
                    <td style="text-align:right;">
                        <label for="empresa">Empresa <i>(nível de acesso)</i> </label>
                    </td>
                    <td>
                        {$obj.rel.empresas.empresa}
                    </td>
                    <td style="text-align:right;">
                        <label for="arquivo_supervisor">Recebe arquivos compartilhados?</label>
                    </td>
                    <td>
                        {if $obj.arquivo_supervisor==1}Sim{else}Não{/if}
                    </td>
                </tr>

                <tr>
                    <td style="text-align:right;">
                        <label for="funcao">Cargo </label>
                    </td>
                    <td>
                        {$obj.funcao}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:right;">
                        <label for="telefone">Telefone </label>
                    </td>
                    <td>
                        {$obj.telefone}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:right;">
                        <label for="email">Email </label>
                    </td>
                    <td>
                        {$obj.email}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align:right;">
                        <label for="perfis_idperfis">Perfil </label>
                    </td>
                    <td>
                        {$obj.rel.perfis.perfil}
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="text-align:right;">
                        <label for="perfis_idperfis">Subperfil <i>(para supervisores)</i></label>
                    </td>
                    <td>
                        {$obj.subperfil}
                    </td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td style="text-align:right;">
                        <label for="login">Login </label>
                    </td>
                    <td>
                        {$obj.login}
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <div class="row" align="center">
                <div class="form-group col-md-12">
                <input type="button" class="btn btn-primary" value="Editar Usuário" onClick="javascript:getAjaxForm('Usuario/edit',false,{ldelim}param:{$obj.idusuarios},ajax:1{rdelim})" />
                </div>
            </div>

        </div>
    </div>
    </form>
</div>
