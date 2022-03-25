
"use strict";

$(document).ready(function() {
    if($('span#toast').data('status')){
        if($('span#toast').data('type')=="error"){
            iziToast.error({
                title: 'Error',
                message: $('span#toast').data('message'),
                position: 'topRight'
            });
        }else{
            iziToast.success({
                title: 'OK!',
                message: $('span#toast').data('message'),
                position: 'topRight'
            });
        }
    }

    if(DataTable){
        var partOfUrl=$(location).attr('href').split("/")
        if(partOfUrl[partOfUrl.length-1]=='user'){
            $("#data-table").dataTable({
                "searching": false,
                "lengthChange": false,
                "paging": false,
                "info": false,
                "columnDefs":  [{"orderable": false,"targets": [3,4] }]
            });
        }else if(partOfUrl[partOfUrl.length-1]=='department'){
            $("#data-table").dataTable({
                "searching": false,
                "lengthChange": false,
                "paging": false,
                "info": false,
                "columnDefs":  [{"orderable": false,"targets": [3] }]
            });
        }else{
            $("#data-table").dataTable({
                "searching": false,
                "lengthChange": false,
                "paging": false,
                "info": false,
                "columnDefs":  [{"orderable": false,"targets": [5] }]
            });
        }
    }

    $('.daterange').daterangepicker({
        locale: {format: 'YYYY-MM-DD'},
        drops: 'down',
        opens: 'right'
    });

    $('.select2').select2();
});
