$(document).ready(function(){
	$("#pramotersTable").DataTable();
	// $("#productTable").DataTable({
 //        "order": [[3,"asc"]]
 //    });
    $("#markAsDone").click(function(){
    	$("#changeProductStatus").submit();
    })
});