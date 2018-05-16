$( "#dialog" ).dialog({
	autoOpen: false,
	width: 400,
	buttons: [
		{
			text: "Ok",
			click: function() {
				$( this ).dialog( "close" );
			}
		},
		{
			text: "Cancel",
			click: function() {
				$( this ).dialog( "close" );
			}
		}
	]
});

// Link to open the dialog
// $( "#dialog-link" ).click(function( event ) {
// 	$( "#dialog" ).dialog( "open" );
// 	event.preventDefault();
// });

function displayDialog(id){
	var id = "#dialog"+id; 
	open(id);
}

function open(id){
	$(id).dialog( "open" );
	event.preventDefault();
}