<div class="container1" style="margin-top: 0px;">
	<div class="row">
		{include file="OS/submenu.tpl" title=submenu}
	</div>
</div>
<br>
<center>
	
	<table class="tbLista tableMonitor">
		<thead>
		    <tr>
		        <th>VSAT</th>
		        <th>STATUS</th>
		        <th>ALARME</th>
		        <th>DATA</th>
		        <th>PERÍODO OFF</th>
		        <th>MIN OFF</th>
		        <th>N LOGOFF</th>
		        <th>AÇÕES</th>
		    </tr>
		</thead>
		
		<tbody>
		    {foreach from=$arr item=obj}
		    {cycle values='trCor,trsCor' assign=rowCss}     
		    <tr class="{$rowCss}"  onMouseOver="javascript:onOver(this)" onMouseOut="javascript:onUp(this,'{$rowCss}')">
		        <td class="_filterCol0 _match">{$obj.USERNAME}</td>
		        <td class="_filterCol1 _match">{$obj.STATUS}</td>
		        <td class="_filterCol2 _match {$obj.COR}">{$obj.ALARME}</td>
		        <td class="_filterCol3 _match">{$obj.TIMESTAMP}</td>
		        <td class="_filterCol4 _match">{$obj.PERIOD}</td>
		        <td class="_filterCol5 _match">{$obj.CONTADOR}</td>
		        <td class="_filterCol6 _match">{$obj.NLOGOFF}</td>
		        <td class="_filterCol7 _match">
		        	<!--  <a href="#" onClick="javascript:getAjaxForm('Incidente/create','',{ldelim}param:{$obj.VSAT_ID},ajax:1{rdelim})">Abrir incidente</a> -->
		        </td>
		    </tr>
		    {/foreach}
		</tbody>
	</table>
</center>