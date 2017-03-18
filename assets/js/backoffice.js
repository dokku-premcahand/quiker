$(document).ready(function(){
	$('.datepicker').datepicker({
		dateFormat : "yy-mm-dd"
	});

	$("#markAsDone").click(function(){
		$("#changeProductStatus").submit();
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
					for(var cnt in data){
						console.log(data[cnt]['id']);
						html += "<tr class='success'><td>"+data[cnt]['id']+"</td>";
						html += "<td>"+data[cnt]['name']+"</td>";
						html += "<td>"+data[cnt]['phone_number']+"</td>";
						html += "<td>"+data[cnt]['marital_status']+"</td>";
						html += "<td>"+data[cnt]['email']+"</td>";
						html += "<td>"+data[cnt]['pramoterName']+"</td>";
						html += "<td><input type='checkbox' name=product[]' id='product_"+data[cnt]['id']+"' value='"+data[cnt]['id']+"'></td></tr>";
					}
					$("#productTable").children('tbody').append(html);
					var sound = document.getElementById('myAudio');
					sound.play();
            	}
            }
        });
		setTimeout(function(){message();}, 30000);
	}
});