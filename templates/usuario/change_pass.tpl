

<div class="container1" style="width: 32%; margin-top: 80px; margin-bottom: 30%;">
    <form action="Usuario/create" method="POST" id="fUsEdit" class="form" >
        <input type="hidden" name="idusuarios" value="{$login.idusuarios}">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Alterar Senha</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <input class="form-control" type="password"  name="senha" id="senha" placeholder="Nova Senha"/>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <input class="form-control" type="password" name="conf_senha" id="conf_senha" placeholder="Confirma a Nova Senha" />
                    </div>
                </div>

                <div class="row" align="center">
                    <div class="form-group">
                        <input type="button" class="btn btn-primary" value="Alterar Senha" onClick="verifSenha(Ext.getDom('senha').value,Ext.getDom('conf_senha').value)" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>