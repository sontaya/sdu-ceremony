"use strict";

// Class definition
var KTDashboard = function() {

    var cdsSummary = function() {
        if ($('#kt_chart_cds_summary').length == 0) {
            return;
        }


        $.ajax({
            url: base_url+"admin/report_practice_summary",
            type: 'POST',
            dataType: 'json',
            success: function (res)
            {
                var resSummary = res[0];
                Morris.Donut({
                    element: 'kt_chart_cds_summary',
                    data: [

                        {
                            label: "พิมพ์บัตรซ้อมแล้ว",
                            value: resSummary.COUNT_PRINT
                        },
                        {
                            label: "ยังไม่พิมพ์",
                            value: resSummary.COUNT_NO
                        }
                    ],
                    colors: [
                        KTApp.getStateColor('success'),
                        KTApp.getStateColor('warning'),
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
				source: base_url+"admin/report_practice_list",
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
					field: 'RECORD_NO',
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
					field: 'GRADUATE_STATUS',
					title: 'สถานะ',
				},{
					field: 'LATEST_PRINT_DATE_DESC',
					title: 'วันที่พิมพ์ล่าสุด',
					type: 'date',
				}],

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
