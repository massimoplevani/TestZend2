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
	if(pathname.indexOf('modifica-polizza') != -1 ||pathname.indexOf('dettaglio-polizza') != -1){
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


 	var idTipo = $("select[name=tipopolizza]").val();
 	if(idTipo == '1' && $("#casoCasa").hasClass('hidden')){
		$("#casoAuto").addClass('hidden');
		$("#casoCasa").removeClass('hidden');
	
	}else if(idTipo == '2' && $("#casoAuto").hasClass('hidden') ){
		$("#casoCasa").addClass('hidden');
		$("#casoAuto").removeClass('hidden');
		
	}

  } );

 $(document).on("click",".accept-cookie",function () {
	console.log("eentro");
	$.ajax({
	  url: "/setinformativa",
	}).done(function() {
	  $("#ContainerCookie").remove();
	});
	
});

