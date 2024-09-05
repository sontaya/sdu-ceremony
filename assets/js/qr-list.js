"use strict";


var KTDatatableJson = function () {
	// Private functions

	// basic demo
	var dataList = function () {

		var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: base_url+"admin/graduate_timestamp",
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
				},{
					field: 'CREATED_DATE_TH',
					title: 'วันที่ลงเวลา',
					type: 'date',
					format: 'MM/DD/YYYY HH24:mi:ss',
				},{
					field: 'CREATED_BY',
					title: 'ผู้บันทึกเวลา',
				}
            ],
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
    KTDatatableJson.init();
});
