/**
 * 
 */

	function escolhaCampo(valor){
		var vez1 = document.getElementById(valor);
//		alert(valor);
		vez1.value='';

	}
	function voltaCampo(valor){
		var vez1 = document.getElementById(valor).value;
		if(vez1 == ''){
			return document.getElementById(valor).value ='0.00';
		}else{
			return false;
		}

	}
	
	function referencaCampoUni(){
		
		var qtd = document.getElementById('qtd_serv_adesao').value;
		var adesUni =  document.getElementById('preco_serv_adesao_uni').value;

		if(qtd != 0){
			adesUni = adesUni.replace(/\D/g,"");
			var adesTotal =  parseFloat(qtd*adesUni);
			document.getElementById('preco_serv_adesao_total').value = adesTotal;
			adesTotal = document.getElementById('preco_serv_adesao_total').value;
			adesTotal = adesTotal.replace(/(\d)(\d{5})$/,"$1,$2");
			adesTotal = adesTotal.replace(/(\d)(\d{2})$/,"$1.$2");
			
			
		}else{
			var adesTotal =  parseFloat(qtd*adesUni);
				adesTotal = '0,00';			
		}
		document.getElementById('preco_serv_adesao_total').value = adesTotal;
		document.getElementById('preco_servico').value = adesTotal;

	}
	
	
	
	function referencaCampoProv(){
		
		var qtdps = document.getElementById('qtd_prov_serv').value;
		var psu = document.getElementById('preco_prov_serv_uni').value;

		var qtdpv = document.getElementById('qtd_prov_voip').value;
		var pvu = document.getElementById('preco_prov_voip_uni').value;
		
		var qtdpl = document.getElementById('qtd_prov_licenca').value;
		var plu = document.getElementById('preco_prov_licenca_uni').value;
		
		var qtdpip = document.getElementById('qtd_prov_ip').value;
		var pip = document.getElementById('preco_prov_ip_uni').value;
		
		var pst = document.getElementById('preco_prov_serv_total').value;
		var pvt = document.getElementById('preco_prov_voip_total').value;
		var plt = document.getElementById('preco_prov_licenca_total').value;
		var pit = document.getElementById('preco_prov_ip_total').value;
	
	//--------TRATAMENTO DO PROVIMENTO DE SERVIÇO TOTAL--------
		if (qtdps != 0){
			
			psu = psu.replace(/\D/g,"");
			pvt = pvt.replace(/\D/g,"");
			plt = plt.replace(/\D/g,"");
			pit = pit.replace(/\D/g,"");
			var provServTotal = parseFloat(qtdps*psu);
			pitpltpvt = parseInt(plt)+ parseInt(pit)+ parseInt(pvt);

				
			precoProvimento = parseFloat(provServTotal)+parseFloat(pitpltpvt);
			
			document.getElementById('preco_prov_serv_total').value = provServTotal;
			provServTotal = document.getElementById('preco_prov_serv_total').value;
			provServTotal = provServTotal.replace(/(\d)(\d{5})$/,"$1,$2");
			provServTotal = provServTotal.replace(/(\d)(\d{2})$/,"$1.$2");

			document.getElementById('preco_provimento').value = precoProvimento;
			precoProvimento = document.getElementById('preco_provimento').value;
			precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1.$2");
			precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
			
		}else{
			psu = psu.replace(/\D/g,"");
			
			pst = pst.replace(/\D/g,"");
			pvt = pvt.replace(/\D/g,"");
			plt = plt.replace(/\D/g,"");
			pit = pit.replace(/\D/g,"");

			var provServTotal = parseFloat(qtdps*psu);
			pitpstpltpvt = parseInt(pst)+ parseInt(plt)+ parseInt(pit)+ parseInt(pvt);

			precoProvimento = parseFloat(provServTotal+pitpstpltpvt);
			
			document.getElementById('preco_provimento').value = precoProvimento;
			precoProvimento = document.getElementById('preco_provimento').value;
			precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1,$2");
			precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
			precoProvimento = precoProvimento != 0? precoProvimento: '0.00';
			provServTotal = '0,00';	

		}
			pst = document.getElementById('preco_prov_serv_total').value = provServTotal;
			
			
			//--------TRATAMENTO DO PROVIMENTO VOIP TOTAL--------
			if (qtdpv != 0){
				
				pvu = pvu.replace(/\D/g,"");
				var provVoipTotal = parseFloat(qtdpv*pvu);
				pst = pst.replace(/\D/g,"");
				plt = plt.replace(/\D/g,"");
				pit = pit.replace(/\D/g,"");
				pitpltpst = parseInt(plt)+ parseInt(pit)+ parseInt(pst);
				
				
				precoProvimento = parseFloat(provVoipTotal)+ parseFloat(pitpltpst);
				
				document.getElementById('preco_prov_voip_total').value = provVoipTotal;
				provVoipTotal = document.getElementById('preco_prov_voip_total').value;
				provVoipTotal = provVoipTotal.replace(/(\d)(\d{5})$/,"$1,$2");
				provVoipTotal = provVoipTotal.replace(/(\d)(\d{2})$/,"$1.$2");
				
				document.getElementById('preco_provimento').value = precoProvimento;
				precoProvimento = document.getElementById('preco_provimento').value;
				precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1.$2");
				precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
				
			}else{
				pvu = psu.replace(/\D/g,"");
				pvt = pvt.replace(/\D/g,"");
				pst = pst.replace(/\D/g,"");
				plt = plt.replace(/\D/g,"");
				pit = pit.replace(/\D/g,"");
				
				var provServTotal = parseFloat(qtdps*psu);
				pitpstplt = parseInt(pst)+ parseInt(plt)+ parseInt(pit)+ parseInt(pvt);
				
				precoProvimento = parseFloat(provServTotal+pitpstplt);
				
				document.getElementById('preco_provimento').value = precoProvimento;
				precoProvimento = document.getElementById('preco_provimento').value;
				precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1,$2");
				precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
				precoProvimento = precoProvimento != 0? precoProvimento: '0.00';
				provVoipTotal = '0,00';	
				
			}
			pvt = document.getElementById('preco_prov_voip_total').value = provVoipTotal;
		
	//--------TRATAMENTO DO PROVIMENTO DE LICENÇA TOTAL--------
		if (qtdpl != 0){
			plu = plu.replace(/\D/g,"");
			var provLicTotal = parseFloat(qtdpl*plu);
			pvt = pvt.replace(/\D/g,"");
			pst = pst.replace(/\D/g,"");
			pit = pit.replace(/\D/g,"");
			
			pitpstpvt = parseInt(pst)+ parseInt(pit)+ parseInt(pvt);
			
			precoProvimento = parseFloat(provLicTotal+pitpstpvt);
			
			document.getElementById('preco_prov_licenca_total').value = provLicTotal;
			provLicTotal = document.getElementById('preco_prov_licenca_total').value;
			provLicTotal = provLicTotal.replace(/(\d)(\d{5})$/,"$1,$2");
			provLicTotal = provLicTotal.replace(/(\d)(\d{2})$/,"$1.$2");
			
			document.getElementById('preco_provimento').value = precoProvimento;
			precoProvimento = document.getElementById('preco_provimento').value;
			precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1,$2");
			precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
			
		}else{

			plu = plu.replace(/\D/g,"");
			pvt = pvt.replace(/\D/g,"");
			pst = pst.replace(/\D/g,"");
			plt = plt.replace(/\D/g,"");
			pit = pit.replace(/\D/g,"");

			var provLicTotal = parseFloat(qtdpl*plu);
			pitpstpltpvt = parseInt(pst)+ parseInt(plt)+ parseInt(pit)+ parseInt(pvt);

			precoProvimento = parseFloat(provLicTotal+pitpstpltpvt);
			
			document.getElementById('preco_provimento').value = precoProvimento;
			precoProvimento = document.getElementById('preco_provimento').value;
			precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1,$2");
			precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
			precoProvimento = precoProvimento != 0? precoProvimento: '0.00';
			provLicTotal = '0,00';	
		}
		plt = document.getElementById('preco_prov_licenca_total').value = provLicTotal;
		
		//--------TRATAMENTO DO PROVIMENTO DE IP TOTAL--------
		if (qtdpip != 0){
			pip = pip.replace(/\D/g,"");
			var provIpTotal = parseFloat(qtdpip*pip);			
			pvt = pvt.replace(/\D/g,"");
			pst = pst.replace(/\D/g,"");
			plt = plt.replace(/\D/g,"");
			
			pltpstpvt = parseInt(pst)+ parseInt(plt)+ parseInt(pvt);
			
			precoProvimento = parseFloat(provIpTotal+pltpstpvt);
			
			document.getElementById('preco_prov_ip_total').value = provIpTotal;
			provIpTotal = document.getElementById('preco_prov_ip_total').value;
			provIpTotal = provIpTotal.replace(/(\d)(\d{5})$/,"$1,$2");
			provIpTotal = provIpTotal.replace(/(\d)(\d{2})$/,"$1.$2");
			
			document.getElementById('preco_provimento').value = precoProvimento;
			precoProvimento = document.getElementById('preco_provimento').value;
			precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1,$2");
			precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
			
		}else{
			pit = '0.00';
			pip = pip.replace(/\D/g,"");
			pvt = pvt.replace(/\D/g,"");
			pst = pst.replace(/\D/g,"");
			plt = plt.replace(/\D/g,"");
			pit = pit.replace(/\D/g,"");
			
			var provIpTotal = parseFloat(qtdpip*pip);
			pitpstpltpvt = parseInt(pst)+ parseInt(plt)+ parseInt(pit)+ parseInt(pvt);
			
			precoProvimento = parseFloat(provIpTotal+pitpstpltpvt);
			
			document.getElementById('preco_provimento').value = precoProvimento;
			precoProvimento = document.getElementById('preco_provimento').value;
			precoProvimento = precoProvimento.replace(/(\d)(\d{5})$/,"$1,$2");
			precoProvimento = precoProvimento.replace(/(\d)(\d{2})$/,"$1.$2");
			precoProvimento = precoProvimento != 0? precoProvimento: '0.00';
			provIpTotal = '0,00';	
		}
		document.getElementById('preco_prov_ip_total').value = provIpTotal;
		
		
		
		document.getElementById('preco_provimento').value = precoProvimento;

		
	}