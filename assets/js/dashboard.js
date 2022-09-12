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
                            label: "เข้ารับ",
                            value: resSummary.COUNT_OK
                        },
                        {
                            label: "ไม่เข้ารับ",
                            value: resSummary.COUNT_NO
                        },
                        {
                            label: "n/a",
                            value: resSummary.COUNT_TENTATIVE
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
					field: 'STD_ORDER',
					title: '#',
                    width: 50,
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
					field: 'GRAD_CONFIRM_STATUS',
					title: 'สถานะรายงานตัวบัณฑิต',
				}, {
					field: 'STD_CONFIRM_STATUS',
					title: 'สถานะยืนยัน',
				},{
					field: 'STD_CONFIRM_DATE',
					title: 'วันที่ยืนยัน',
					type: 'date',
					format: 'MM/DD/YYYY HH24:mi:ss',
				}],

		});


        $('#std_confirm_status').on('change', function() {
        datatable.search($(this).val(), 'STD_CONFIRM_STATUS');
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
