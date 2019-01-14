<div class="container1" style="width: 35%">

    <div class="row">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Dados do Cliente</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <h2>{$obj.empresa}</h2>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        Prefixo :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.prefixo}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        Contato :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.contatoFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        CNPJ :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.cnpjFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        Endereço :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.enderecoFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        País :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.paisFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        Cidade :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.cidadeFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        Estado :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.estadoFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        CEP :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.cepFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3 font">
                        E-mail :
                    </div>
                    <div class="form-group col-md-9">
                        {$obj.emailFaturamento}
                    </div>
                </div>
                <div class="row">
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary" value="Editar" onClick="javascript:getAjaxForm('Cliente_sp/edit',false,{ldelim}param:{$obj.idempresas},ajax:1{rdelim})">
                        Editar
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>