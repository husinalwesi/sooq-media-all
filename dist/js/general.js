$(document).ready(function(){
	var upload_img_default = "dist/img/150x100.png";
	jQuery.fn.exists = function(){return this.length>0;}
	var ajax_url = 'index.php?type=ajax';


    if($(".datetime_picker_range")[0]){
        var date_from_timestamp = $("#date_from_timestamp").val();
        var date_to_timestamp = $("#date_to_timestamp").val();        
        
        if(date_from_timestamp && date_to_timestamp){
           $('.datetime_picker_range').daterangepicker({
                startDate: moment(date_from_timestamp).format('MM/DD/YYYY'),
                endDate: moment(date_to_timestamp).format('MM/DD/YYYY')
           });            
        }else{
           $('.datetime_picker_range').daterangepicker();            
        }
    }


	$(".ignore-contract-end").on("click",function(){
		var id = $(this).attr("data-id");
		var params = "action=ignore_contract_end&id=" + id;
		callAjax(params,"ignore_contract_end");
	});

	$(".renew-contract").on("click",function(){
		var id = $(this).attr("data-id");
		var params = "action=renew_contract&id=" + id;
		callAjax(params,"renew_contract");
		$(this).parent().parent().remove();
	});

	$("#accordion .panel").on("click",function(){
		$(this).find(".panel-collapse").toggleClass("active");
	});


	home_page_class_parent_table_red_color();
	function home_page_class_parent_table_red_color(){
		if($(".row-red")[0]){
			$("tr .row-red").each(function(index){
				$(this).removeClass("row-red");
				$(this).parent().parent().addClass("row-red");
			});
		}
	// row-red
	}


	calculate_total_finance_table();
	function calculate_total_finance_table(){
		if($(".table-finance-online")[0]){
			//
		 setTimeout(function(){
			 var total_dollar = 0;
			 var total_jordan_dinar = 0;
			 $(".table-finance-online > tbody > tr").each(function(index){
				 console.log($(this));
			   var dollar = $(this).find("td:nth-child(4)").text();
			   var jordan_dinar = $(this).find("td:nth-child(5)").text();
			   dollar = parseInt(dollar);
			   jordan_dinar = parseInt(jordan_dinar);
			   if(!isNaN(jordan_dinar)) total_jordan_dinar+=jordan_dinar;
			   if(!isNaN(dollar)) total_dollar+=dollar;
			 });
			 $(".total_online_finance_jd").text(total_dollar);
			 $(".total_online_finance_dollar").text(total_jordan_dinar);
		 });
		}
	}

	function check_if_there_is_more_pending(){
		if($(".timeline li").length <= 1){
			// show empty
			$("#no_more_load").show();
		}
		// #no_more_load
		return true;
	}

	check_if_there_is_more_pending();

	$(".export-to-pdf").on("click",function(){
		var filename = "كشف حساب.pdf";
		var url = window.location.search;
		if(url == "?type=account_statement_new&action=view") filename = "كشف ذمم.pdf";

		// alert(1);
		$("#invoice").show();
		const element = document.getElementById("invoice");
		var opt = {
			filename: filename,
			margin: [0.5,0,1,0],
      html2canvas: {dpi: 192, scale: 2, letterRendering: true},
      pagebreak: {mode: 'avoid-all'},
  		jsPDF: {
				unit: 'in',
				format: 'letter',
				orientation: 'portrait'
			}
		};
		html2pdf().set(opt).from(element).save();

		setTimeout(function() {
			$("#invoice").hide();
			// alert(1);
		}, 5000);
	});


	$(".payment-table-id tbody tr").each(function(index){
		var id = $(this).find("> td:nth-child(1)").text();
		$(this).attr("data-id",id);
	});

	$(".print-payment").on("click",function(){
		var id = $(this).attr("data-id");
		$("#invoice").show();
		$("#invoice tbody tr").hide();
		$("#invoice tbody tr[data-id='" + id + "']").show();

		const element = document.getElementById("invoice");
		var opt = {
			filename:'قيد.pdf',
			margin: [0.5,0,1,0],
      pagebreak: {mode: 'avoid-all'},
      html2canvas: {dpi: 192, scale: 2, letterRendering: true},
			jsPDF: {
				unit: 'in',
				format: 'letter',
				orientation: 'portrait'
			}
		};
		html2pdf().set(opt).from(element).save();

		setTimeout(function(){
			$("#invoice").hide();
		}, 5000);
	});

	$(".re-send-pending").on("click",function(){
		var id = $(this).attr("data-id");
		//
		var status = 0;
		var params = "action=update_status_online_finance_managment&id=" + id + "&status=" + status;
		callAjax(params,"update_status_online_finance_managment");
		// alert(id);
		$(this).parent().parent().find(" > td:nth-child(7)").html('<i class="fa fa-circle-o yellow"></i> قيد الإنتظار');
		$(this).remove();
	});

	$(".accept_reject_payment").on("click",function(){
		var id = $(this).attr("data-id");
		var status = $(this).attr("data-type");
		var params = "action=update_status_online_finance_managment&id=" + id + "&status=" + status;
		$("li[data-id='" + id + "']").remove();
		check_if_there_is_more_pending();
		callAjax(params,"update_status_online_finance_managment");
		handle_num_sidenav();
	});

	function handle_num_sidenav(){
		var old_no = parseInt($("li.active.pending_online_finance_managment small").text());
		var new_no = old_no - 1;
		if(new_no == 0){
			$("li.active.pending_online_finance_managment small").remove();
		}else{
			$("li.active.pending_online_finance_managment small").text(new_no);
		}
		return true;
	}

	$("body").on("click","#addBackupLog",function(){
		callAjax("action=addBackupLog","addBackupLog");
	});


	if($("table")[0] && $("table a.btn")[0]){
		$("table thead tr > th:last-child").addClass("action-th-table");
	}


function callAjax(params,action)
{
	// waitProgress(true);
	$.ajax({
        type: "POST",
        url: ajax_url,
        data: params,
        dataType: 'json',
        success: function(data){
					if(data.status == 200){
						// console.log(action);
						switch(action){
  						case String(action.match(/^delete.*/)): //delete action(s)..
								swal("تم الحذف","تم الحذف بنجاح", "success");
							break;

							case "sendLng":
				        location.reload();
							break;

							case "ignore_contract_end":
					 			location.reload();
							break;

							case "renew_contract":
								swal("تم بنجاح.","تم تجديد الإشترك بنجاح.", "success");
							break;

							case "update_status_online_finance_managment":
								swal("تمت العملية","تمت العملية بنجاح.", "success");
							break;

							case "addBackupLog":
								window.open($("#api_url").val() + 'generateBackup&token_id=123456','Back-up Window', 'width=800, height=600');
								// refresh here..
							break;

							default:
						}
					}else{
						error_ajax();
					}
					// waitProgress(false);
		},
        error: function(){
					error_ajax();
		}
	});
    return false;
}

	function error_ajax(){
		swal("Error Occur","some error occurred while calling ajax", "error");
		// waitProgress(false);
	}

	$("body").on("click",".delete-table-static",function(){
		swal({
		  title: "هل أنت متأكد من الحذف؟",
		  text: "إذا تم الحذف لا يمكن إرجاع المحذوف!",
		  // text: "Once deleted, you will not be able to recover this imaginary file!",
		  icon: "warning",
		  buttons: true,
    	buttons: ['لا', 'موافق'],
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) {
				var action = $(this).attr("class");
				var id = $(this).attr("data-id");
				action = action.replace("btn btn-danger delete-table-static ","");
				var params = "action=" + action + "&id=" + id;
				callAjax(params,action);
				$(this).parent().parent().remove();
		  }
		});
	});



	initialize_dataTable();
	function initialize_dataTable(){
		if($(".data-table")[0]){

			$(".content-wrapper .data-table").each(function(index){
				var $this = this;
				$($this).find("tr").each(function(index){
					if(!$(this).html().trim()){
						$(this).remove();
					}
	      });

				var table = $($this).DataTable({
					//order the data table descending order
					order: [[0, "desc" ]],
					language: {
						 url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Arabic.json"
					 },
			});

      });
	}
}


	$(".advance-search-btn").on("click",function(){
		$(".super-seach-toggle").fadeToggle();
		$(this).toggleClass("active");
	});






//end of document Jquery
	});
//
//
//
//
//
jQuery_v1(document).ready(function(){
	if(jQuery_v1('.select-single-auto')[0]){
		jQuery_v1('.select-single-auto').selectize({
		    create: false,
		    sortField: 'text'
		});
	}
});
