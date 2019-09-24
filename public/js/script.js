$(document).on("change","select[name=tipopolizza]",function () {
	var idTipo = $(this).val();

	if(idTipo == '1' && $("#casoCasa").hasClass('hidden')){
		$("#casoAuto").addClass('hidden');
		$("#casoCasa").removeClass('hidden');
		$.each($("#casoAuto input"),function(){
			$(this).val("");
		})

	}else if(idTipo == '2' && $("#casoAuto").hasClass('hidden') ){
		$("#casoCasa").addClass('hidden');
		$("#casoAuto").removeClass('hidden');
		$.each($("#casoCasa input"),function(){
			$(this).val("");
		})
	}
	
});
	
	var pathname = window.location.pathname;
	console.log($("a[href='/elenco-polizza']").hasClass("active"));
	if(pathname.indexOf('modifica-polizza') !== false || pathname.indexOf('dettaglio-polizza') !== false){
		if($("a[href='/elenco-polizza']").hasClass("active") == false){
			window.setTimeout(function(){
				$("a[href='/elenco-polizza']").parent().addClass("active");
			},10)
			
		}
	}


 $( function() {
 	var dataEmissione = $( "input[name=dataEmissione]" ).val();
 	var dataScadenza =$( "input[name=dataScadenza]" ).val();
    $( "input[name=dataEmissione]" ).datepicker();
     $( "input[name=dataEmissione]" ).datepicker( "option", "dateFormat", 'dd-mm-yy');

      $( "input[name=dataScadenza]" ).datepicker();
     $( "input[name=dataScadenza]" ).datepicker( "option", "dateFormat", 'dd-mm-yy');
     $( "input[name=dataEmissione]" ).val(dataEmissione);
 	 $( "input[name=dataScadenza]" ).val(dataScadenza);
  } );

