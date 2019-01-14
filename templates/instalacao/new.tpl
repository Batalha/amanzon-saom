
<div class="container1" style="width: 50%;">
    <form action="Instalacao/create" method="POST" id="FINSCreate" class="form" >
        <input type="hidden" name="os_idos" id="os_idos" value="{$param}"/>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Dados da Vsat</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <input class="form-control" type="text" name="nome" id="nome" />
                    </div>
                    <div class="form-group col-md-6">
                        <input class="form-control" type="text" name="mac" id="mac" placeholder="MAC" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" id="iplan" name="iplan" class='form-control' value="{$obj.rel.os.iplan}" />
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" id="os_ipdvb" name="os_ipdvb" class='form-control' value="{$obj.rel.os.ipdvb}" />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <input type="text" id="mascaraLan" name="mascaraLan" class='form-control'  />
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <input class="form-control" type="text" readonly="readonly" value="Vsat foi criada no WEBNMS?">
                            <span class="input-group-addon">
                                <input type="checkbox" name="webnms" id="webnms" />
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <input class="form-control" type="text" readonly="readonly" value="Testou Sat Link 2000?">
                            <span class="input-group-addon">
                                <input type="checkbox" name="test_sl2000" id="test_sl2000" />
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <textarea class="form-control" name="obs" id="obs" style="height: 100px;" placeholder="Observação"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <input type="button" class="btn btn-primary" value="Cadastrar dados" onClick="javascript:sendPost('Instalacao/create','FINSCreate')" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>