$(document).ready(function(){
	$('.datepicker').datepicker({
		dateFormat : "yy-mm-dd"
	});

	$("#markAsDone").click(function(){
		$("#changeProductStatus").attr("action",baseURL+"backoffice/changeProductStatus");
		if($("input[name='product[]']").is(":checked")){
			$("#changeProductStatus").submit();			
		}
		else{
			alert("Please select the entries to mark done");
			return false;
		}
	});

	$("#exportSelected").click(function(){
		if($("input[name='product[]']").is(":checked")){
			$("#changeProductStatus").attr("action",baseURL+"backoffice/exportSelected");
			$("#changeProductStatus").submit();
		}
		else{
			alert("Please select the entries to Export");
			return false;
		}
	});

	$("#pullSearchData").click(function(){
		$("#searchForm").attr("action",baseURL+"backoffice/export");
		$("#searchForm").submit();
	});

	message();
	function message() {
		var latestProductId = $("#latestProductId").val();
		$.ajax({
            url: baseURL+"./backoffice/latestProducts",
            type: "POST",
            data: { id : latestProductId },
			dataType:"JSON",
            success:function(data){
            	if(data != 1){
					var html="";
					var id;
					for(var cnt in data){
						var trClass = "success";
						
						if(data[cnt]['is_duplicate'] == 1){
							trClass = "alert alert-danger";
						}
						
						id = data[cnt]['id'];
						html += "<tr class='"+trClass+"'><td><input type='checkbox' name='product[]' id='product_"+data[cnt]['id']+"' value='"+data[cnt]['id']+"'></td>";
						html += "<td>"+data[cnt]['sequence']+"</td>";
						html += "<td>"+data[cnt]['name']+"</td>";
						html += "<td>"+data[cnt]['phone_number']+"</td>";
						html += "<td>"+data[cnt]['marital_status']+"</td>";
						html += "<td>"+data[cnt]['payment_type']+"</td>";
						html += "<td>"+data[cnt]['aadhar']+"</td>";
						html += "<td>"+data[cnt]['father_name']+"</td>";
						html += "<td>"+data[cnt]['father_age']+"</td>";
						html += "<td>"+data[cnt]['caste']+"</td>";
						html += "<td>"+data[cnt]['house_type']+"</td>";
						html += "<td>"+data[cnt]['salary']+"</td>";
						html += "<td>"+data[cnt]['email']+"</td>";
						html += "<td>"+data[cnt]['pramoterName']+"</td>";
						html += "<td>"+data[cnt]['date']+"</td></tr>";
					}
					$("#productTable").children('tbody').append(html);
					$("#latestProductId").val(id);
					var sound = document.getElementById('myAudio');
					sound.play();
            	}
            }
        });
		setTimeout(function(){message();}, 10000);
	}
});