<script type="text/javascript">
    initDataTable();
    initDataTable1();
    initDataTable2();
    initDataTable3();


    function initDataTable() {
        $('#apps1').DataTable({
            "order": [
                [0, "asc"]
            ],
            "language": {
                "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                "searchPlaceholder": "search",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            }
        });
    }

    function initDataTable1() {
        $('#apps2').DataTable({
            "order": [
                [0, "asc"]
            ],
            "language": {
                "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                "searchPlaceholder": "search",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            }
        });
    }

    function initDataTable2() {
        $('#apps3').DataTable({
            "order": [
                [0, "asc"]
            ],
            "language": {
                "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                "searchPlaceholder": "search",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            }
        });

    }
    function initDataTable3() {
        $('#apps4').DataTable({
            "order": [
                [0, "asc"]
            ],
            "language": {
                "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
                "searchPlaceholder": "search",
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            }
        });
    }

    $(function() {
        var targetAllProduct = [];
        $('#target').change(function() {
            targetAllProduct = [];
            var target_name = $("#target").val();
            // alert(target_name);
            $.ajax({
                url: '/admin/targets/' + target_name,
                type: 'GET',
                success: function(data) {
                    // alert(data);
                    $('#product').removeAttr('disabled');
                    $('#product').empty();
                    $('#product').append(
                        '<option value="Select Product" selected=selected>Select Product</option>'
                        );
                    $('#product').append('<option value="999">All</option>');

                    for (var i = 0; i < data.length; i++) {
                        targetAllProduct.push(data[i].id);
                        $('#product').append('<option value=' + data[i].id + '>' + data[i]
                            .product + '</option>');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        $('#product').change(function() {
            var str = '';
            var product_id = $("#product").val();
            var target = $("#target").val();
            $.ajax({
                url: '/admin/appproducts/products/' + product_id + '/' + target,
                type: 'GET',
                success: function(data) {
                  // console.log(data);
                    var urlPreview = '{{ route('admin.applications.preview', ':id') }}';
                    var urlPrint = '{{ route('admin.applications.print', ':id') }}';
                    var Sno=1;
                    for (var j = 0; j < data.length; j++)
                        if(data[j].app_no !=null && data[j].status == 'S'){
                        {
                        var flag_name1=  data[j].flag_name;
                        if(flag_name1==null)
                        {
                            flag_name1='No Action';
                        }
                            if( data[j].round=='1')
                            {
                            urlPreview = urlPreview.replace(':id', data[j].id);
                            urlPrint = urlPrint.replace(':id', data[j].id);
                            view_app = '<a href="' + urlPreview +
                                    '" class="btn btn-info btn-sm btn-block"><i class="right fas fa-eye"></i></a>';
                            printt = '<a href="' + urlPrint +
                                    '"class="btn btn-info btn-sm btn-block" target="_blank"><i class="fas fa-print"></i></a>';
                            status = 'SUBMITTED';
                            var submitAtDate = new Date(data[j].submitted_at);
                            var createAtDate = new Date(data[j].created_at);
                            str = str + '<tr><td>' +
                                (Sno++) +
                                '</td><td>' +
                                data[j].name +
                                '</td><td>' +
                                data[j].product +
                                '</td><td>' +
                                data[j].app_no +
                                '</td><td><span class="text-success"><b>' +
                                status + '</b></span></td><td><span class="text-primary"><b>' +
                                    flag_name1+'</td><td>'+
                                createAtDate.getDate() + "/" + (createAtDate.getMonth() + 1) +
                                '/' + createAtDate.getFullYear() +
                                '</td><td>' +
                                submitAtDate.getDate() + "/" + (submitAtDate.getMonth() + 1) +
                                '/' + submitAtDate.getFullYear() +
                                '</td><td>' +
                                view_app +
                                '</td><td>' +
                                printt +
                                '</td></tr>';
                            }
                        }
                }
                    // console.log(str);
                   if ($.fn.DataTable.isDataTable("#apps1")) {
                        $('#apps1').DataTable().clear().destroy();
                    }
                    $('#apps1 tbody').empty();
                    $('#apps1').append(str);
                    initDataTable();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        });
});

$(function() {
        var targetAllProduct = [];
        $('#target1').change(function() {
            targetAllProduct = [];
            var target_name = $("#target1").val();
            // alert(target_name);
            $.ajax({
                url: '/admin/targets/' + target_name,
                type: 'GET',
                success: function(data) {
                    // alert(data);
                    $('#product1').removeAttr('disabled');
                    $('#product1').empty();
                    $('#product1').append(
                        '<option value="Select Product" selected=selected>Select Product</option>'
                        );
                    $('#product1').append('<option value="999">All</option>');

                    for (var i = 0; i < data.length; i++) {
                        targetAllProduct.push(data[i].id);
                        $('#product1').append('<option value=' + data[i].id + '>' + data[i]
                            .product + '</option>');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        $('#product1').change(function() {
            var str = '';
            var product_id = $("#product1").val();
            var target = $("#target1").val();
            $.ajax({
                url: '/admin/appproducts/products/' + product_id + '/' + target,
                type: 'GET',
                success: function(data) {
                  // console.log(data);
                    var urlPreview = '{{ route('admin.applications.preview', ':id') }}';
                    var urlPrint = '{{ route('admin.applications.print', ':id') }}';
                    var Sno=1;
                    for (var j = 0; j < data.length; j++)
                        if(data[j].app_no !=null){
                        {
                        var flag_name1=  data[j].flag_name;
                        if(flag_name1==null)
                        {
                            flag_name1='No Action';
                        }
                            if( data[j].round=='2')
                            {
                            urlPreview = urlPreview.replace(':id', data[j].id);
                            urlPrint = urlPrint.replace(':id', data[j].id);
                            view_app = '<a href="' + urlPreview +
                                    '" class="btn btn-info btn-sm btn-block"><i class="right fas fa-eye"></i></a>';
                            printt = '<a href="' + urlPrint +
                                    '"class="btn btn-info btn-sm btn-block" target="_blank"><i class="fas fa-print"></i></a>';
                            status = 'SUBMITTED';
                            var submitAtDate = new Date(data[j].submitted_at);
                            var createAtDate = new Date(data[j].created_at);
                            str = str + '<tr><td>' +
                                (Sno++) +
                                '</td><td>' +
                                data[j].name +
                                '</td><td>' +
                                data[j].product +
                                '</td><td>' +
                                data[j].app_no +
                                '</td><td><span class="text-success"><b>' +
                                status + '</b></span></td><td><span class="text-primary"><b>' +
                                    flag_name1+'</td><td>'+
                                createAtDate.getDate() + "/" + (createAtDate.getMonth() + 1) +
                                '/' + createAtDate.getFullYear() +
                                '</td><td>' +
                                submitAtDate.getDate() + "/" + (submitAtDate.getMonth() + 1) +
                                '/' + submitAtDate.getFullYear() +
                                '</td><td>' +
                                view_app +
                                '</td><td>' +
                                printt +
                                '</td></tr>';
                            }
                        }
                }
                    // console.log(str);
                    if ($.fn.DataTable.isDataTable1("#apps2")) {
                        $('#apps2').DataTable().clear().destroy();
                    }
                    $('#apps2 tbody').empty();
                    $('#apps2').append(str);
                    initDataTable1();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        });
});

$(function() {
        var targetAllProduct = [];
        $('#target2').change(function() {
            targetAllProduct = [];
            var target_name = $("#target2").val();
            // alert(target_name);
            $.ajax({
                url: '/admin/targets/' + target_name,
                type: 'GET',
                success: function(data) {
                    // alert(data);
                    $('#product2').removeAttr('disabled');
                    $('#product2').empty();
                    $('#product2').append(
                        '<option value="Select Product" selected=selected>Select Product</option>'
                        );
                    $('#product2').append('<option value="999">All</option>');

                    for (var i = 0; i < data.length; i++) {
                        targetAllProduct.push(data[i].id);
                        $('#product2').append('<option value=' + data[i].id + '>' + data[i]
                            .product + '</option>');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        $('#product2').change(function() {
            var str = '';
            var product_id = $("#product2").val();
            var target = $("#target2").val();
            $.ajax({
                url: '/admin/appproducts/products/' + product_id + '/' + target,
                type: 'GET',
                success: function(data) {
                  // console.log(data);
                    var urlPreview = '{{ route('admin.applications.preview', ':id') }}';
                    var urlPrint = '{{ route('admin.applications.print', ':id') }}';
                    var Sno=1;
                    for (var j = 0; j < data.length; j++)
                        // if(data[j].app_no !=null){
                        {
                        var flag_name1=  data[j].flag_name;
                        if(flag_name1==null)
                        {
                            flag_name1='No Action';
                        }
                        var app_no1=  data[j].app_no;
                        if(app_no1==null)
                        {
                            app_no1='Not Created';
                        }
                            if( data[j].round=='3')
                            {
                            urlPreview = urlPreview.replace(':id', data[j].id);
                            urlPrint = urlPrint.replace(':id', data[j].id);
                                if (data[j].status == 'S'  ) {
                                    status = 'SUBMITTED';
                                    view_app = '<a href="' + urlPreview +
                                        '" class="btn btn-info btn-sm btn-block"><i class="right fas fa-eye"></i></a>';
                                    printt = '<a href="' + urlPrint +
                                        '"class="btn btn-info btn-sm btn-block" target="_blank"><i class="fas fa-print"></i></a>';
                                    // view_app = 'Wait For Last Date';
                                    // printt = 'Not Visible';
                                } else {
                                    status = 'DRAFT';
                                    view_app =
                                        '<a href="#" class="btn btn-info btn-sm btn-block disabled"><i class="right fas fa-eye"></i></a>';
                                    printt =
                                        '<a href="#" class="btn btn-info btn-sm btn-block disabled"><i class="fas fa-print"></i></a>';
                                    // view_app = 'Wait For Last Date';
                                    // printt = 'Not Visible';
                                }
                            var submitAtDate = new Date(data[j].submitted_at);
                            var createAtDate = new Date(data[j].created_at);

                            str = str + '<tr><td class="text-center">' +
                                (Sno++ )+
                                '</td><td>' +
                                data[j].name +
                                '</td><td class="text-center">' +
                                data[j].product +
                                '</td><td>' +
                                    app_no1 +
                                '</td><td class="text-center"><span class="text-success"><b>' +
                                status + '</b></span></td><td class="text-center"><span class="text-primary"><b>' +
                                    flag_name1+'</td><td class="text-center">'+
                                createAtDate.getDate() + "/" + (createAtDate.getMonth() + 1) +
                                '/' + createAtDate.getFullYear() +
                                '</td><td class="text-center">' +
                                submitAtDate.getDate() + "/" + (submitAtDate.getMonth() + 1) +
                                '/' + submitAtDate.getFullYear() +
                                '</td><td class="text-center">' +
                                view_app +
                                '</td><td class="text-center">' +
                                printt +
                                '</td></tr>';
                            }
                        // }
                    }
                    // console.log(str);
                    if ($.fn.DataTable.isDataTable2("#apps3")) {
                        $('#apps3').DataTable().clear().destroy();
                    }
                    $('#apps3 tbody').empty();
                    $('#apps3').append(str);
                    initDataTable2();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        });
});

$(function() {
        var targetAllProduct = [];
        $('#target3').change(function() {
            targetAllProduct = [];
            var target_name = $("#target3").val();
            // alert(target_name);
            $.ajax({
                url: '/admin/targets/' + target_name,
                type: 'GET',
                success: function(data) {
                    // alert(data);
                    $('#product3').removeAttr('disabled');
                    $('#product3').empty();
                    $('#product3').append(
                        '<option value="Select Product" selected=selected>Select Product</option>'
                        );
                    $('#product3').append('<option value="999">All</option>');

                    for (var i = 0; i < data.length; i++) {
                        targetAllProduct.push(data[i].id);
                        $('#product3').append('<option value=' + data[i].id + '>' + data[i]
                            .product + '</option>');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
        });

        $('#product3').change(function() {
            var str = '';
            var product_id = $("#product3").val();
            var target = $("#target3").val();
            $.ajax({
                url: '/admin/appproducts/products/' + product_id + '/' + target,
                type: 'GET',
                success: function(data) {
                  // console.log(data);
                    var urlPreview = '{{ route('admin.applications.preview', ':id') }}';
                    var urlPrint = '{{ route('admin.applications.print', ':id') }}';
                    var Sno=1;
                    for (var j = 0; j < data.length; j++)
                        // if(data[j].app_no !=null){
                        {
                        var flag_name1=  data[j].flag_name;
                        if(flag_name1==null)
                        {
                            flag_name1='No Action';
                        }
                        var app_no1=  data[j].app_no;
                        if(app_no1==null)
                        {
                            app_no1='Not Created';
                        }
                            if( data[j].round=='4')
                            {
                            urlPreview = urlPreview.replace(':id', data[j].id);
                            urlPrint = urlPrint.replace(':id', data[j].id);
                                if (data[j].status == 'S'  ) {
                                    status = 'SUBMITTED';
                                    view_app = '<a href="' + urlPreview +
                                        '" class="btn btn-info btn-sm btn-block"><i class="right fas fa-eye"></i></a>';
                                    printt = '<a href="' + urlPrint +
                                        '"class="btn btn-info btn-sm btn-block" target="_blank"><i class="fas fa-print"></i></a>';
                                    // view_app = 'Wait For Last Date';
                                    // printt = 'Not Visible';
                                } else {
                                    status = 'DRAFT';
                                    view_app =
                                        '<a href="#" class="btn btn-info btn-sm btn-block disabled"><i class="right fas fa-eye"></i></a>';
                                    printt =
                                        '<a href="#" class="btn btn-info btn-sm btn-block disabled"><i class="fas fa-print"></i></a>';
                                    // view_app = 'Wait For Last Date';
                                    // printt = 'Not Visible';
                                }
                            var submitAtDate = new Date(data[j].submitted_at);
                            var createAtDate = new Date(data[j].created_at);

                            str = str + '<tr><td class="text-center">' +
                                (Sno++ )+
                                '</td><td>' +
                                data[j].name +
                                '</td><td class="text-center">' +
                                data[j].product +
                                '</td><td>' +
                                    app_no1 +
                                '</td><td class="text-center"><span class="text-success"><b>' +
                                status + '</b></span></td><td class="text-center"><span class="text-primary"><b>' +
                                    flag_name1+'</td><td class="text-center">'+
                                createAtDate.getDate() + "/" + (createAtDate.getMonth() + 1) +
                                '/' + createAtDate.getFullYear() +
                                '</td><td class="text-center">' +
                                submitAtDate.getDate() + "/" + (submitAtDate.getMonth() + 1) +
                                '/' + submitAtDate.getFullYear() +
                                '</td><td class="text-center">' +
                                view_app +
                                '</td><td class="text-center">' +
                                printt +
                                '</td></tr>';
                            }
                        // }
                    }
                    // console.log(str);
                    if ($.fn.DataTable.isDataTable3("#apps4")) {
                        $('#apps4').DataTable().clear().destroy();
                    }
                    $('#apps4 tbody').empty();
                    $('#apps4').append(str);
                    initDataTable3();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });

        });
});
</script>
