	function logar(){
		
		var dados = $('#form_login').serialize();
		
		//alert(dados);
			$.ajax({type: "POST",url: "/interweb/funValidaLogin.php",data: dados ,beforeSend: function() {
			
			$('#loading').fadeIn();
			
			},success: function(txt) {
			
			//alert(txt);
			
			var array = txt.split('|');
				switch(parseInt(array[0],10)){
				case 1:
				document.location.href='/interweb';			
				break;
				case 2:
				alert('Usuário não cadastrado');
				break;
				case 3:
				alert('Senha incorreta');
				break;
				case 4:
				alert('Este usuario nao pode acessar nenhum sistema.\nFavor entrar em contato com o gerente.');
				break;
				case 5:
				alert('Este usuario nao pode visualizar nenhuma filial.\nFavor entrar em contato com o gerente.');
				break;
				default:
				alert(txt);
				break;
				}
			
			$('#loading').fadeOut();
			
			}});
		return false;
		}

	function logoff(){
			
			$.ajax({type: "POST",url: "/interweb/funLogoff.php",data: '' ,beforeSend: function() {
			
			//$('#msg_login').html('<img src="images/ajax-loader.gif" style="height:12px" />');
			
			},success: function(txt) {
				
				if(txt == ''){		
				document.location.href='/interweb';
				} else {
				alert('Erro ao deslogar \n '+txt);
				}
			
			}});
		
	}
	
	function continuarListagem(funcao){
		var posicaoAtual = $(window).scrollTop();
		var documentSize = $(document).height();
		var sizeWindow = $(window).height();
		
		$(window).scroll(function () {
			posicaoAtual = $(window).scrollTop();
		if ( posicaoAtual >= (documentSize - sizeWindow ) ) {
				if(typeof(funcao)=="function"){
					funcao.call();
				}
			}
		});
		
		$(window).resize(function() {
			posicaoAtual = $(window).scrollTop();
			documentSize = $(document).height();
			sizeWindow = $(window).height();
		});
		
	}
	
	function selecionar(tr){
		
		$(tr).parent().children('.selecionado').removeClass('selecionado');
		$(tr).addClass('selecionado');
		
		//alert($(tr).closest('form').attr("name"));
		//document.forms[$(tr).closest('form').attr("name")].selecionado.value = cont;
		//document.form1.selecionado.value = cont;
	
	}
	
	function esconder(camada){
		
		$('#camada'+camada).fadeOut();
		$('#camada'+camada).html();
		
	}
	
	function validarCNPJ(cnpj){
       // alert(cnpj);
		//var cnpj = ObjCnpj.value;
        var valida = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
        var dig1= new Number;
        var dig2= new Number;
        
        exp = /\.|\-|\//g
        cnpj = cnpj.toString().replace( exp, "" ); 
        var digito = new Number(eval(cnpj.charAt(12)+cnpj.charAt(13)));
                
        for(i = 0; i<valida.length; i++){
                dig1 += (i>0? (cnpj.charAt(i-1)*valida[i]):0);  
                dig2 += cnpj.charAt(i)*valida[i];       
        }
        dig1 = (((dig1%11)<2)? 0:(11-(dig1%11)));
        dig2 = (((dig2%11)<2)? 0:(11-(dig2%11)));
        
        if(((dig1*10)+dig2) != digito){  
                alert('CNPJ Invalido!');
				document.form1.cnpj.value = document.form1.documentocadastrado.value;
				return false;      
				}
				else{
				return true;
				}
                
	}
	
	
	function validarCPF(cpf){
		//alert(cpf)
		
		exp = /\.|\-|\//g
		cpf = cpf.toString().replace( exp, "" );
		
		if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
		return false;
		add = 0;
		for (i=0; i < 9; i ++)
		add += parseInt(cpf.charAt(i)) * (10 - i);
		rev = 11 - (add % 11);
		if (rev == 10 || rev == 11)
		rev = 0;
		if (rev != parseInt(cpf.charAt(9)))
		return false;
		add = 0;
		for (i = 0; i < 10; i ++)
		add += parseInt(cpf.charAt(i)) * (11 - i);
		rev = 11 - (add % 11);
		if (rev == 10 || rev == 11)
		rev = 0;
		if (rev != parseInt(cpf.charAt(10)))
		return false;
		
		//alert('O CPF INFORMADO É VÁLIDO.');
		return true;
	}
	
	function validarDocumento(documento){
		//alert(documento);
		var res = true;
		if(documento.length > 14){
			res = validarCNPJ(documento);
			return res;
		} else {
			res = validarCPF(documento);
			return res;
		}
	}
	
	function selecionarCombo(campo,itemSelecionar){
		//alert(itemSelecionar);
		var _elemento = document.getElementById(''+campo);							   
		for ( i =0; i < _elemento.length; i++){
			_elemento[i].selected = _elemento[i].value == itemSelecionar ? true : false;
		}       
    }
	
	function selecionarRadio(form,campo,itemSelecionar){
		var _elemento = document.forms[''+form].elements[''+campo];
		//alert(_elemento);					   
		for ( i =0; i < _elemento.length; i++){
			//alert(_elemento[i].value);
			if(_elemento[i].value == itemSelecionar){
				_elemento[i].checked = true;
			}
			//_elemento[i].selected = _elemento[i].value == itemSelecionar ? true : false;
		}       
    }
	
	function float2moeda(num){
    x = 0;

    if(num<0)
    {
    num = Math.abs(num);
    x = 1;
    }

    if(isNaN(num))
    num = "0";

    cents = Math.floor((num*100+0.5)%100);

    num = Math.floor((num*100+0.5)/100).toString();

    if(cents < 10) cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
    num = num.substring(0,num.length-(4*i+3))+'.'+num.substring(num.length-(4*i+3)); ret = num + ',' + cents;

    if (x == 1)
    ret = '-' + ret;

    return ret;
    }
	
	function moeda2float(num){
		ret = parseFloat(num.replace(/\./g,"").replace(",","."));
		
		if(isNaN(ret)) { 
			ret = 0.00; 
		} else {
			ret = ret.toFixed(2);	
		}
		
		return parseFloat(ret);
	}
	
	function autorizarModulo(form){
		var dados = $(form).serialize();
		
		//alert(dados);
		
		$.ajax({type: "POST",url: "/interweb/funAutorizarModulo.php",data: dados ,beforeSend: function() {
			
			//$('#msg_login').html('<img src="images/ajax-loader.gif" style="height:12px" />');
			
			},success: function(txt) {
				
				//alert(txt);
			
				if(txt == 0){		
					alert('Senha incorreta');
				} else {
					var array = txt.split('|');
					$(form).parent().html(array[0]);
					document.location.href=array[1];
				}
			
		}});
		
		return false;
	}
	
	function navegar(keyCode){
		//alert(keyCode);
		if($('#camada1').css('display') != 'block' & $('#camada2').css('display') != 'block'){
			if (keyCode == 40) {
				//alert( "down pressed" );
				tr = $('.selecionado');
				//alert($(tr).next().html());
				if($(tr).next().is('tr')){
					$(tr).removeClass('selecionado');
					$(tr).next().addClass('selecionado');
					//alert($(tr).next().offset().top);
					$('html, body').scrollTop((($(tr).next().offset().top)-200));
				} else {
					consulta();
				}
				return false;
			} else {
				if (keyCode == 38) {
				   //	alert( "up pressed" );
					tr = $('.selecionado');
					//alert($(tr).prev().html());
					if($(tr).prev().is('tr')){
						$(tr).removeClass('selecionado');
						$(tr).prev().addClass('selecionado');
						//alert($(tr).prev().offset().top);
						$('html, body').scrollTop((($(tr).prev().offset().top)-200));
					}
					return false;
				}
			}
		}
	}