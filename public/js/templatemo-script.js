/*
 *	www.templatemo.com
 *******************************************************/

/* HTML document is loaded. DOM is ready. 
-----------------------------------------*/
$(document).ready(function(){

	/* Mobile menu */
	$('.mobile-menu-icon').click(function(){
		$('.templatemo-left-nav').slideToggle();				
	});

	/* Close the widget when clicked on close button */
	$('.templatemo-content-widget .fa-times').click(function(){
		$(this).parent().slideUp(function(){
			$(this).hide();
		});
	});
});

$('.submenu > a').click(function(e)
{
	e.preventDefault();
	var submenu = $(this).siblings('ul');
	var li = $(this).parents('li');
	var submenus = $('.templatemo-left-nav li.submenu ul');
	var submenus_parents = $('.templatemo-left-nav li.submenu');
	if(li.hasClass('open'))
	{
		if(($(window).width() > 768) || ($(window).width() < 479)) {
			submenu.slideUp();
		} else {
			submenu.fadeOut(250);
		}
		li.removeClass('open');
		li.find('a:first').removeClass('active');
	} else 
	{
		if(($(window).width() > 768) || ($(window).width() < 479)) {
			submenus.slideUp();			
			submenu.slideDown();
		} else {
			submenus.fadeOut(250);			
			submenu.fadeIn(250);
		}
		submenus_parents.removeClass('open');
		submenus_parents.find('a:first').removeClass('active');
		li.addClass('open');
		li.find('a:first').addClass('active');
	}
});

// Limpa os caracteres não numerais do valor digitado
function Limpar(valor, validos) {
	var result = "";
	var aux;
	for (var i=0; i < valor.length; i++) {
		aux = validos.indexOf(valor.substring(i, i+1));
		if (aux>=0)
			result += aux;
	}
	return result;
}

// Função para formatar inputs decimal
function Formata(campo,tammax,teclapres,decimal) {
	var tecla = teclapres.keyCode;
	vr = Limpar(campo.value,"0123456789");
	tam = vr.length;
	dec=decimal

	if (tam < tammax && tecla != 8) tam = vr.length + 1;
	if (tecla == 8 ) tam = tam - 1;
	if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
		if ( tam <= dec ) campo.value = vr;
		if ( (tam > dec) && (tam <= 5) )campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam );
		if ( (tam >= 6) && (tam <= 8) ) campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam );
		if ( (tam >= 9) && (tam <= 11) ) campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ); 
		if ( (tam >= 12) && (tam <= 14) ) campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ); 
		if ( (tam >= 15) && (tam <= 17) ) campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam );
	} 
}

// Valida se o texto digitado é um número
function validar_numero(evt) {
	var theEvent = evt || window.event;
	if(theEvent.keyCode == "13")
		return true;
	var key = theEvent.keyCode || theEvent.which;
	key = String.fromCharCode( key );
	var regex = /[0-9]|\./;
	if( !regex.test(key) ) {
		theEvent.returnValue = false;
		if(theEvent.preventDefault) theEvent.preventDefault();
	}
}

// Transfere a url para o modal de deletar registro
function confirm_delete(url) {
	$('#form-delete').attr('action', url);
}

// Masks
$('input#cpf,input.cpf').mask('000.000.000-00');
$('input#cep,input.cep').mask('00000-000');
$('input#celular,input.celular').mask('(00) 00000-0000');
$('input#telefone,input.telefone').mask('(00) 0000-0000');
$('input#matricula,input#matri.ula').mask('00.000-0');
$('input#pis,input.pis').mask('000.00000.00-0');