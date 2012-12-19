$(document).ready(function(){
		
	// first example
	$("#navigation").treeview({
		collapsed: true,
		unique: true,
		persist: "location"
	});

	
	// second example
	$("#browser").treeview({
		animated:"normal",
		persist: "cookie"
	});



	// third example
	$("#red").treeview({
		animated: "fast",
		collapsed: true,
		control: "#treecontrol"
	});


});