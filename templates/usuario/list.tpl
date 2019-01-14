<br>
<div class="container1">
	<div class="row">
		<div class="form-group">
			{include file="usuario/submenu.tpl" title=submenu}
		</div>
	</div>
</div>

<div class="container1-fluid">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title text-center">Lista de Usuários</div>
		</div>
		<div class="panel-body"  style="padding: 0px;">

			<table class="table table-striped tbLista tableUsuario">
				<thead>
					<th>Nome</th>
					<th>Empresa</th>
					<th>Cargo</th>
					<th>Telefone</th>
					<th>Email</th>
					<th>Login</th>
					<th>Perfil</th>
					<th>Açoes</th>
				</thead>
				<tbody>
				{foreach from=$arr item=obj}
					<tr class="{$rowCss}">
						<td >{if isset($obj.nome)}{$obj.nome}{/if}</td>
						<td >{if isset($obj.nome_empresa)}{$obj.nome_empresa}{/if}</td>
						<td >{if isset($obj.funcao)}{$obj.funcao}{/if}</td>
						<td >{if isset($obj.telefone)}{$obj.telefone}{/if}</td>
						<td >{if isset($obj.email)}{$obj.email}{/if}</td>
						<td >{if isset($obj.login)}{$obj.login}{/if}</td>
						<td >{if isset($obj.nome_perfil)}{$obj.nome_perfil}{/if}</td>
						<td >
							<button type="button" class="btn btn-info" value="Views" onClick="javascript:getAjaxForm('Usuario/view','conteudo',{ldelim}param:{$obj.idusuarios},ajax:1{rdelim})">
								<i class="glyphicon glyphicon-eye-open"></i>
							</button>
							<button type="button" class="btn btn-primary" value="Editar" onClick="javascript:getAjaxForm('Usuario/edit',false,{ldelim}param:{$obj.idusuarios},ajax:1{rdelim})">
								<i class="glyphicon glyphicon-edit"></i>
							</button>
						</td>

					</tr>
				{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>