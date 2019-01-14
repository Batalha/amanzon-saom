<br>
<div class="container1">
    <div class="row">
        <div class="form-group">
            {include file="municipio/submenu.tpl" title=submenu}
        </div>
    </div>
</div>
<br>
<div class="container" style="width: 30%; margin-bottom: 30%;">
    <form action="Municipio/create" method="POST" id="fMacroCreate" class="form" >
        <input type="hidden" name="idmunicipios"  />
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title text-center">Editar Municipio</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <input class="form-control autosave_municipios" type="text" name="municipio" id="municipio"  />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <div class="">
                            <input class="form-control autosave_municipios" type="text" name="macroregiao" id="macroregiao"   />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 text-center">
                        <input type="button" class="btn btn-primary" value="Enviar" onClick="javascript:sendPost('Municipio/create','fMacroCreate')" />                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
