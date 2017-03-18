$(document).ready(function(){
	$("#pramotersTable").DataTable();
	// $("#productTable").DataTable({
		// "order": [[3,"asc"]]
	// });

    // $("#markAsDone").click(function(){
    // 	$("#changeProductStatus").submit();
    // });

	$("#pullSearchData").click(function(){
		$("#searchForm").attr("action",baseURL+"admin/export");
		$("#searchForm").submit();
	});

	$('.datepicker').datepicker({
		dateFormat : "yy-mm-dd"
	});
});