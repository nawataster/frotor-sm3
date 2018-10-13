var dummy_path
	,list_opts = {
	 "info":"desc",
	 "sort":"id"
	}
	,list_path
;


/**
 * extends alert functionality. Also sets global is_submit to false.
 * @param string title
 * @param string message
 * @returns void
 */
function inform( title, message, focusId, callback ){

	std_dlg
		.dialog( "option", "width", "450px" )
	    .dialog( "option", "title", title )
		.dialog( "option", "buttons",[
			{
				text: "Close",
				click: function(){
					$(this).dialog("close");
					(typeof focusId != "undefined" && focusId != null) ? $("#"+focusId).focus() : null;
					(typeof callback != "undefined") ? callback() : null;
				}
			}
		])
		.html( message )
		.dialog("open");
}
//______________________________________________________________________________

/**
 * extends confirm functionality.
 * @param title
 * @param message
 * @param callback
 */
function affirm( title, message, callback ){
	std_dlg
		.dialog( "option", "width", "450px" )
	    .dialog( "option", "title", title )
		.dialog( "option", "buttons",[
			{
				"text": "Yes",
				"click": function(){
					$(this).dialog("close");
					(typeof callback != "undefined" ) ? callback() : null;
				}
				,"id": "aff_yes_btn"
			},

			{
				"text": "No",
				"click": function(){
					$(this).dialog("close");
				}
				,"id": "aff_no_btn"

			}
		])
		.html( message )
		.dialog("open");

		$("#aff_no_btn").focus()
		;
}
//______________________________________________________________________________

function loadFaucet( faucet_url, isNewTab ){
	if( isNewTab ){
		window.open( faucet_url, "_blank" );
		$("#main_fraim").attr( "src", dummy_path );

		$( "#load_btn" )
			.removeClass( "glyphicon-repeat" )
			.addClass( "glyphicon-play" )
			.attr( "title","Show current faucet" );

		return;
	}

	$("#main_fraim").attr( "src", faucet_url );

	$( "#load_btn" )
		.removeClass( "glyphicon-play" )
		.addClass( "glyphicon-repeat" )
		.attr( "title","Refresh" );
}
//______________________________________________________________________________

function processAction( url, fdata ){
	var res	= true;

	$.ajax({
		url: url,
		type: "POST",
		async: true,
		dataType: "json",
		data: fdata,
		success: function( data, textStatus, jqXHR ) {

			if( !data.success ){
				inform( "Warn", data.Message );
				return false;
			}

			if( data.post.action == "save_duration" ){
				inform( "Operation result", data.Message );
				$("#oduration").val(data.post.cduration);
				return false;
			}

			if( data.post.action != "change_order" &&  data.post.action != "change_debt" )
				window.location.href = data.post.url;
		},
		error: function( jqXHR, textStatus, errorThrown ) {
			alert( "JS system error." );
		}
	});
}
//______________________________________________________________________________ $(this).attr("id")

function showFaucetListModal(){
	$('#faucets_list_modal').modal('show');

	$(".faucet-list-opt").click(function(ev){
		var ind = $(this).attr("name")+"_"+$(this).val()

		,dtt	= {
			"info":$("[name=info]").val(),
			"sort":$("[name=sort]").val()
		}
	;


alert(111);
//debugger;

		$(this).attr("name") == "info" ? list_opts.info = $(this).val() : list_opts.sort = $(this).val();

		$.ajax({
			url: list_path,
	        type: "POST",
			dataType: "json",
			data: "",
	        success: function(content) {
	        	$("div#faucets_list_modal div.modal-body").html(content);
	        }
	    });
	});
}
//______________________________________________________________________________

$(document).ready(function(){

	$.ajaxSetup({
		   headers: { "X-CSRF-Token" : $("meta[name=_token]").attr("content") }
	});

	std_dlg	= $("#standard-dialog").dialog({
		autoOpen: false,
		dialogClass: "dialog-standard",
 		position: { my: "center center-100", at: "ceter center-100", of: window },
		modal: true
	});

});
