"use strict";

// Class definition
var KTDashboard = function() {

    var cdsSummary = function() {
        if ($('#kt_chart_cds_summary').length == 0) {
            return;
        }


        $.ajax({
            url: base_url+"admin/report_summary",
            type: 'POST',
            dataType: 'json',
            success: function (res)
            {
                var resSummary = res[0];
                Morris.Donut({
                    element: 'kt_chart_cds_summary',
                    data: [

                        {
                            label: "ยืนยัน",
                            value: resSummary.COUNT_APPROVE
                        },
                        {
                            label: "รอการยืนยัน",
                            value: resSummary.COUNT_PENDING
                        },
                        {
                            label: "ปฏิเสธ",
                            value: resSummary.COUNT_REJECT
                        },
                        {
                            label: "n/a",
                            value: resSummary.COUNT_NULL
                        }
                    ],
                    colors: [
                        KTApp.getStateColor('success'),
                        KTApp.getStateColor('warning'),
                        KTApp.getStateColor('info'),
                        KTApp.getStateColor('primary'),
                        KTApp.getStateColor('danger')
                    ],
                });

            },
            error: function (request, status, message) {
                console.log('Ajax Error!! ' + status + ' : ' + message);
            },
        });

        $.ajax({
            url: base_url+"admin/report_gradstatus_summary",
            type: 'POST',
            dataType: 'json',
            success: function (res)
            {
                var resSummary = res[0];
                Morris.Donut({
                    element: 'kt_chart_grad_status',
                    data: [

                        {
                            label: "ปกติ",
                            value: resSummary.COUNT_1
                        },
                        {
                            label: "เข้ารับ ไม่ชำระเงินรายตัว",
                            value: resSummary.COUNT_2
                        },
                        {
                            label: "ไม่เข้ารับ",
                            value: resSummary.COUNT_3
                        },
                        {
                            label: "ไม่เข้ารับ ไม่ชำระเงินค่ารายงานตัว",
                            value: resSummary.COUNT_4
                        },
                        {
                            label: "ไม่รายงานตัว",
                            value: resSummary.COUNT_5
                        }
                    ],
                    colors: [
                        KTApp.getStateColor('success'),
                        KTApp.getStateColor('warning'),
                        KTApp.getStateColor('info'),
                        KTApp.getStateColor('primary'),
                        KTApp.getStateColor('danger')
                    ],
                });

            },
            error: function (request, status, message) {
                console.log('Ajax Error!! ' + status + ' : ' + message);
            },
        });


    }

    return {
        // Init demos
        init: function() {
            // init charts



            cdsSummary();

            // demo loading
            var loading = new KTDialog({'type': 'loader', 'placement': 'top center', 'message': 'Loading ...'});
            loading.show();

            setTimeout(function() {
                loading.hide();
            }, 3000);
        }
    };
}();

var KTDatatableJson = function () {
	// Private functions

	// basic demo
	var dataList = function () {

		var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: base_url+"admin/report_list",
				pageSize: 10,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#generalSearch')
			},

			// columns definition
			columns: [
                {
                    field: 'ID_PHOTO',
                    title: 'Image',
                    width: 60,
                    template: function(row) {
                        return '<a href="' + base_url + 'uploads/' + row.ID_PHOTO + '" class="image-popup"><img src="' + base_url + 'uploads/' + row.ID_PHOTO + '" alt="Image" style="width: 60px; height: auto;"/></a>';
                    }
                },{
					field: 'GRAD_ORDER',
					title: 'ลำดับที่',
                    width: 70,
				}, {
					field: 'STD_CODE',
					title: 'รหัสนักศึกษา',
				}, {
					field: 'FULLNAME',
					title: 'ชื่อ-นามสกุล',
				}, {
					field: 'DEGREENAMETH',
					title: 'หลักสูตร',
				}, {
					field: 'REMARK_GET_DESC',
					title: 'สถานะการเข้ารับ',
				}, {
					field: 'UPLOAD_STATUS',
					title: 'สถานะการอัพโหลด',
                    template: function(row) {
                        if (row.UPLOAD_STATUS === null || row.UPLOAD_STATUS == "") {
                            return null;
                        }
                        var status = {
                            'pending': {'title': 'รอการยืนยัน', 'class': 'kt-badge--primary'},
                            'approve': {'title': 'ยืนยัน', 'class': 'kt-badge--success'},
                            'reject': {'title': 'ปฏิเสธ', 'class': 'kt-badge--danger'}
                        };
                        return '<span style="width: 140px;"><span class="kt-badge ' + status[row.UPLOAD_STATUS].class + ' kt-badge--inline kt-badge--pill">'+  status[row.UPLOAD_STATUS].title +'</span></span>';
                    }
				},{
					field: 'UPLOAD_DATE_TH',
					title: 'วันที่อัพโหลด',
					type: 'date',
					format: 'MM/DD/YYYY HH24:mi:ss',
				},{
                    field: 'Actions',
                    title: 'Actions',
                    sortable: false,
                    overflow: 'visible',
                    template: function(row) {
                        return `
                            <div class="dropdown">
                                <button class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">
                                    <i class="la la-cog"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item info-action" href="#" data-id="${row.STD_CODE}"><i class="la la-info-circle"></i> Information</a>
                                    <a class="dropdown-item approve-action" href="#" data-id="${row.STD_CODE}"><i class="la la-check"></i> Approve</a>
                                    <a class="dropdown-item reject-action" href="#" data-id="${row.STD_CODE}"><i class="la la-times"></i> Reject</a>
                                    <a class="dropdown-item remark-action" href="#" data-id="${row.STD_CODE}" data-remark="${row.REMARK_GET}"><i class="la la-retweet"></i> Remark</a>
                                    <a class="dropdown-item practice-action" href="#" data-id="${row.STD_CODE}"><i class="la la-file-pdf-o"></i> เอกสารซ้อมย่อย</a>
                                </div>
                            </div>
                        `;
                    }
                }
            ],
		});

        datatable.on('kt-datatable--on-layout-updated', function() {
            $('.image-popup').magnificPopup({
                type: 'image',
                // gallery: {
                //     enabled: true
                // }
            });
        });

        // Handle Approve Action
        $(document).on('click', '.approve-action', function(e) {
            e.preventDefault();
            var userId = $(this).data('id');
            $.ajax({
                url: base_url + "admin/approve/" + userId,
                type: "POST",
                success: function(response) {
                    toastr.success("อนุมัติเรียบร้อย");
                    datatable.reload();
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        });

        // Handle Reject Form Submission
        $('#rejectForm').submit(function(e) {
            e.preventDefault();
            var userId = $('#rejectUserId').val();
            var reason = $('#rejectReason').val();
            $.ajax({
                url: base_url + "admin/reject",
                type: "POST",
                data: {
                    user_id: userId,
                    reason: reason
                },
                success: function(response) {

                    toastr.info("ยกเลิกข้อมูลเรียบร้อย");
                    $('#rejectModal').modal('hide');
                    datatable.reload();
                    // setTimeout(function (){}, 2000);


                    // console.log(response);
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        });

        // Handle Remark Form Submission
        $('#remarkForm').submit(function(e) {
            e.preventDefault();
            var userId = $('#remarkUserId').val();
            var remarkGet = $('#remarkGet').val();
            $.ajax({
                url: base_url + "admin/remark",
                type: "POST",
                data: {
                    user_id: userId,
                    remarkGet: remarkGet
                },
                success: function(response) {

                    toastr.info("ปรับปรุงข้อมูลเรียบร้อย");
                    $('#remarkModal').modal('hide');
                    datatable.reload();
                    // setTimeout(function (){}, 2000);


                    // console.log(response);
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        });

        // Handle practice Action
        $(document).on('click', '.practice-action', function(e) {
            e.preventDefault();
            var userId = $(this).data('id');
            // var targetUrl = base_url + "admin/practice/" + userId;

            $.ajax({
                url: base_url + "admin/practice_encrypt_target/" + userId,
                dataType: 'json',
                type: "POST",
                success: function(response) {
                    // window.open(targetUrl);
                    console.log(base_url+"export/id/"+ response.encrypt);
                    window.open(base_url+"export/id/"+ response.encrypt);
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        });

        // Handle Reject Action
        $(document).on('click', '.reject-action', function(e) {
            e.preventDefault();
            var userId = $(this).data('id');
            $('#rejectUserId').val(userId);
            $('#rejectReason').val("");
            $('#rejectModal').modal('show');
        });

        // Handle Remark Action
        $(document).on('click', '.remark-action', function(e) {
            e.preventDefault();

            var userId = $(this).data('id');
            var remark = $(this).data('remark');
            // console.log("Remark:"+remark);
            // console.log('Remark Action: ' + userId);
            $('#remarkUserId').val(userId);
            $("#remarkGet").val(remark).change();
            $('#remarkModal').modal('show');
        });

        // Handle practiceInfoModal Action
        $(document).on('click', '.info-action', function(e) {
            e.preventDefault();

            var userId = $(this).data('id');

            $.ajax({
                url: base_url + "admin/view",
                type: "POST",
                data: {
                    user_id: userId,
                },
                success: function(response) {

                    let html = `<span>ชื่อ – สกุล <strong>${response.PREFIX_NAME_TH} ${response.FIRST_NAME_TH} ${response.LAST_NAME_TH}</strong></span><span>&nbsp;&nbsp;ลำดับที่&nbsp;<strong>${response.GRAD_ORDER}</strong></span><br />`;
                    html += `<span>สาขาวิชา <strong>${response.DEGREENAMETH}</strong></span><span>&nbsp;&nbsp;เกรดเฉลี่ย&nbsp;<strong>${response.GPA}</strong></span><br />`;

                    if (response.PRACTICE_STATUS === "Y") {
                        html += `<br /><span><strong>วันซ้อมย่อย ${response.PRE_DATE}</strong></span><br />`;
                        html += `<span><b>รอบ</b> ${response.PRE_CALL}</span>${response.CALL_PLACE} อาคารมหาวชิราลงกรณ ถนนสิรินธร</span><br />`;
                    }

                    html += `<br /><span><strong>วันซ้อมใหญ่ (สวมครุย) ${response.PRE_DATEROUND}</strong></span><br />`;
                    html += `<span>${response.PRE_ROUND}</span><span>&nbsp;&nbsp;เรียกแถวเวลา&nbsp;&nbsp;${response.PRE_CALLROUND}</span><br />`;
                    html += `<span>สถานที่<strong>&nbsp;${response.PRE_CALL_PLACE}</strong></span><br />`;

                    html += `<br /><span><strong>วันรับจริง&nbsp;${response.GET_DATE}&nbsp;&nbsp;${response.GET_ROUND}</strong></span><br />`;
                    html += `<span>เรียกแถวเวลา<strong>&nbsp;${response.GET_CALL}</strong></span><span>&nbsp;&nbsp;สถานที่ <strong>${response.GETCALL_PLACE}</strong></span>`;


                    $("#practice-info-body").html(html)
                },
                error: function(xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });



            $('#practiceInfoModal').modal('show');

        });


        $('#request_upload_status').on('change', function() {
            datatable.search($(this).val(), 'UPLOAD_STATUS');
        });

        $('#get_remark_status').on('change', function() {
            datatable.search($(this).val(), 'REMARK_GET');
        });


	};

	return {
		// public functions
		init: function () {
			dataList();
		}
	};
}();


// Class initialization on page load
jQuery(document).ready(function() {
    KTDashboard.init();
    KTDatatableJson.init();
});
