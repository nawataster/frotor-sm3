var faucet_id=0, std_dlg
	,faucet_url	= ""
;
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

function loadFaucet( isNewTab ){
	if( isNewTab ){
		window.open( faucet_url, "_blank" );
		return;
	}

	$("#main_fraim").attr( "src", faucet_url );

	$( "#load_btn" )
		.removeClass( "glyphicon-play" )
		.addClass( "glyphicon-repeat" )
		.attr( "title","Refresh" );
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
