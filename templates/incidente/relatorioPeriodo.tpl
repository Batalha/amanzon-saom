
<div class="container1" style="width: 40%">
    <form action="Incidente/relatorio" method="post" id="RCreate" class="form" >

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Relatório Incidente Período</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <input type="text" name="data_inicio" id="data_inicio" size="10" class="form-control" placeholder="Data de Inicio"
                                   onchange="javascript:verificaDataRelatorio()"/>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="input-group">
                            <input type="text" name="data_fim" id="data_fim" size="10" class="form-control" placeholder="Data de Fim"
                                   onchange="javascript:verificaDataRelatorio()" />
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <hr>
                        <input type="submit" class="btn btn-primary " id="subitRelatorioIncidente" value="Gerar Relatorio" />
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
