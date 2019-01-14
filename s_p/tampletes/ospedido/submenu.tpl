
    
<div class="btn-group submenu-os-item">

	<span class="btn btn-inverse" style="width:150px;text-align:right;">OS Pedido:&nbsp;</span>

    {if $login.perfis_idperfis != 3}
        <a class="btn" id="li_submenu_novopedidoos_sp" href="#novopedidoos_sp" onClick="javascript:getAjaxForm('OsPedido/create')">Cadastrar Pedido OS</a>
    {/if}    
   	
   	<a class="btn" id="li_submenu_listapedidoos_sp" href="#listapedidoos_sp" onClick="javascript:getAjaxForm('OsPedido/lista')">Ver lista de Pedido OS</a>
</div>