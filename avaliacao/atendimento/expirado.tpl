<link rel="stylesheet" href="css/style.css">
    {if $obg != true}
        <div class="container exp1">
            <div class="row text-center">
                <div class="form-group col-md-12 fontExp">
                    <script>
                        window.setTimeout(function(){
                            alert('Sessao Expirado!');
                            location.href="/"
                        },1000);
                    </script>
                </div>
            </div>
        </div>
    {else}

        <div class="container exp2">
            <div class="row text-center">
                <div class="form-group col-md-12 fontExp">
                    <script>
                        window.setTimeout(function(){
                            alert('Obrigado por nos ajudar a melhorar o atendimento!');
                            location.href="/"
                        },1000);
                    </script>

                </div>
            </div>
        </div>
    {/if}
