

<div class="container1" style="width: 35%">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">SLA's</div>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <label for="">ATENDIMENTO</label>
                <hr>
                </div>
                <div class="form-group col-md-6">
                    <p>Tempo da 1ª Resposta</p>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Dia">
                    </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Hs">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Min">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <p>Tempo de Update/Folloup</p>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Dia">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Hs">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Min">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="form-group col-md-6">
                    <strong>TICKETS MTTR</strong>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Dia">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Hs">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Min">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <strong>CAMPO MTTR</strong>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Dia">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Hs">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" class="form-control" placeholder="Min">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Precisa Update Mandatorio?"/>
                            <span class="input-group-addon">
                                <input type="radio" name="mandatorio" id="mandatorio" value="sim" onclick="return chekQtLinhas(this)">
                                <label for="">Sim</label>
                                <input type="radio" name="mandatorio" id="mandatorio" value="nao" onclick="return chekQtLinhas(this)">
                                <label for="">Não</label>
                            </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Cliente Vip?"/>
                            <span class="input-group-addon">
                                <input type="radio" name="vip" id="vip" value="sim" onclick="return chekQtLinhas(this)">
                                <label for="">Sim</label>
                                <input type="radio" name="vip" id="vip" value="nao" onclick="return chekQtLinhas(this)">
                                <label for="">Não</label>
                            </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Segunda"/>
                        <span class="input-group-addon">
                            <input type="checkbox" name="dia" id="seg" value="seg" onclick="return chekQtLinhas(this)">
                        </span>
                        <input class="form-control" type="text" name="hsinicio" id="hsinicioseg" maxlength="5" placeholder="Hs Inicio"
                               onclick="javascript: $('#hsinicioseg').val('') "
                               onkeyup="Mask(this, time)"
                        />
                        <span class="input-group-addon">/</span>
                        <input class="form-control " type="text" name="hsfim" id="hsfimseg" maxlength="5" placeholder="Hs Fim"
                               onclick="javascript: $('#hsfimseg').val('') "
                               onkeyup="Mask(this, time)"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Terça"/>
                        <span class="input-group-addon">
                            <input type="checkbox" name="dia" id="ter" value="ter" onclick="return chekQtLinhas(this)">
                        </span>
                        <input class="form-control " type="text" name="hsinicio" id="hsinicioter" maxlength="5"placeholder="Hs Inicio"
                               onclick="javascript: $('#hsinicioter').val('') "
                               onkeyup="Mask(this, time)"
                        />
                        <span class="input-group-addon">/</span>
                        <input class="form-control " type="text" name="hsfim" id="hsfimter" maxlength="5" placeholder="Hs Fim"
                               onclick="javascript: $('#hsfimter').val('') "
                               onkeyup="Mask(this, time)"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Quarta"/>
                        <span class="input-group-addon">
                            <input type="checkbox" name="dia" id="qua" value="qua" onclick="return chekQtLinhas(this)">
                        </span>
                        <input class="form-control " type="text" name="hsinicio" id="hsinicioqua" maxlength="5" placeholder="Hs Inicio"
                               onclick="javascript: $('#hsinicioqua').val('') "
                               onkeyup="Mask(this, time)"
                        />
                        <span class="input-group-addon">/</span>
                        <input class="form-control " type="text" name="hsfim" id="hsfimqua" maxlength="5" placeholder="Hs Fim"
                               onclick="javascript: $('#hsfimqua').val('') "
                               onkeyup="Mask(this, time)"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Quinta"/>
                        <span class="input-group-addon">
                            <input type="checkbox" name="dia" id="qui" value="qui" onclick="return chekQtLinhas(this)">
                        </span>
                        <input class="form-control " type="text" name="hsinicio" id="hsinicioqui" maxlength="5" placeholder="Hs Inicio"
                               onclick="javascript: $('#hsinicioqui').val('') "
                               onkeyup="Mask(this, time)"
                        />
                        <span class="input-group-addon">/</span>
                        <input class="form-control " type="text" name="hsfim" id="hsfimqui" maxlength="5" placeholder="Hs Fim"

                               onclick="javascript: $('#hsfimqui').val('') "
                               onkeyup="Mask(this, time)"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Sexta"/>
                        <span class="input-group-addon">
                            <input type="checkbox" name="dia" id="sex" value="sex" onclick="return chekQtLinhas(this)">
                        </span>
                        <input class="form-control " type="text" name="hsinicio" id="hsiniciosex" maxlength="5" placeholder="Hs Inicio"
                               onclick="javascript: $('#hsiniciosex').val('') "
                               onkeyup="Mask(this, time)"
                        />
                        <span class="input-group-addon">/</span>
                        <input class="form-control " type="text" name="hsfim" id="hsfimsex" maxlength="5" placeholder="Hs Fim"
                               onclick="javascript: $('#hsfimsex').val('') "
                               onkeyup="Mask(this, time)"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Sabado"/>
                        <span class="input-group-addon">
                            <input type="checkbox" name="dia" id="sab" value="sab" onclick="return chekQtLinhas(this)">
                        </span>
                        <input class="form-control " type="text" name="hsinicio" id="hsiniciosab" maxlength="5" placeholder="Hs Inicio"
                               onclick="javascript: $('#hsiniciosab').val('') "
                               onkeyup="Mask(this, time)"
                        />
                        <span class="input-group-addon">/</span>
                        <input class="form-control " type="text" name="hsfim" id="hsfimsab" maxlength="5" placeholder="Hs Fim"
                               onclick="javascript: $('#hsfimsab').val('') "
                               onkeyup="Mask(this, time)"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <div class="input-group">
                        <input class="form-control" type="text"  readonly="readonly" value="Domingo"/>
                        <span class="input-group-addon">
                            <input type="checkbox" name="dia" id="dom" value="dom" onclick="return chekQtLinhas(this)">
                        </span>
                        <input class="form-control " type="text" name="hsinicio" id="hsiniciodom" maxlength="5" placeholder="Hs Inicio"
                               onclick="javascript: $('#hsiniciodom').val('') "
                               onkeyup="Mask(this, time)"
                        />
                        <span class="input-group-addon">/</span>
                        <input class="form-control " type="text" name="hsfim" id="hsfimdom" maxlength="5" placeholder="Hs Fim"
                               onclick="javascript: $('#hsfimdom').val('') "
                               onkeyup="Mask(this, time)"
                        />
                    </div>
                    <p style="margin-top: 6px;"><strong style="color: red">Não : </strong>Funciona 24 horas!</p>
                </div>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
</div>