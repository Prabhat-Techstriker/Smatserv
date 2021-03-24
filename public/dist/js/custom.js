function update_status(userId,status) {
	if(userId){
		var urli = '/admin/update-status/'+userId+'/'+status;
		var token =  $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			type: "POST",
			cache: false,
			url:urli,
			data: {'userId':userId,'status':status ,"_token": token},
			dataType: 'json',
			success:function(result){
				console.log("-------",result);
				if (result.code == 200) {
					if (result.admin_approved == 0) {
						$("#status_"+userId).html("<span class='badge badge-secondary'>Pending</span>");
						$("#change_status_"+userId).html("<a href='javascript:' class='badge badge-success' onclick='update_status("+userId+",1)'>Approve</a>");
						$.toast({
							heading: 'Information',
							text: 'provider disapproval updated!.',
							showHideTransition: 'slide',
							icon: 'info',
							position: 'top-right',
						});
					}else{
						$("#status_"+userId).html("<span class='badge badge-info'>Approve</span>");
						$("#change_status_"+userId).html("<a href='javascript:' class='badge badge-danger' onclick='update_status("+userId+",0)'>Disapprove</a>");
						$.toast({
							heading: 'Success',
							text: 'provider approval successfully updated!.',
							showHideTransition: 'slide',
							icon: 'success',
							position: 'top-right',
						});
					}
				}
			}
		});
	}
	else{
		$.toast({
			heading: 'Error',
			text: 'Something went wrong.please try aqgain.',
			showHideTransition: 'fade',
			icon: 'error'
		})
	}
}

$(".sidebar a").each(function() {   
	if (this.href == window.location.href) {
		$(this).addClass("active");
		$(this).parent().parent().parent().addClass('menu-open');
		$(this).parent().parent().prev('a').addClass('active');
	}
});


function delete_user(userId) {
	var urli = '/admin/delete-user';
	var token =  $('meta[name="csrf-token"]').attr('content');
	$.ajax({
			type: "POST",
			cache: false,
			url:urli,
			data: {'userId':userId,'status':status ,"_token": token},
			dataType: 'json',
			success:function(result){
				console.log(result);
				if (result.status == "success") {
					//$(this).closest("tr").remove();
					$.toast({
						heading: 'Success',
						text: 'Data successfully deleted!.',
						showHideTransition: 'slide',
						icon: 'success',
						position: 'top-right',
					});
					location.reload();
				}
			}
		});
}