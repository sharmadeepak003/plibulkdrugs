<script>
   $(document).ready(function () {


$( document ).ajaxStart(function() {
$( "#loading" ).show();
});

$( document ).ajaxStop(function() {
$( "#loading" ).hide();
});
initialiseTable();
function initialiseTable(){
$('#appsAll').DataTable({
    "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    "order": [
        [0, 'asc']
    ],
    "language": {
        "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
        "searchPlaceholder": "search",
        "paginate": {
            "previous": '<i class="fa fa-angle-left"></i>',
            "next": '<i class="fa fa-angle-right"></i>'
        }
    },
});
$('#apps').DataTable({
    
    "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    "order": [
        [0, 'asc']
    ],
    "language": {
        "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
        "searchPlaceholder": "search",
        "paginate": {
            "previous": '<i class="fa fa-angle-left"></i>',
            "next": '<i class="fa fa-angle-right"></i>'
        }
    },
});
$('#apps1').DataTable({
    
    "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    "order": [
        [0, 'asc']
    ],
    "language": {
        "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
        "searchPlaceholder": "search",
        "paginate": {
            "previous": '<i class="fa fa-angle-left"></i>',
            "next": '<i class="fa fa-angle-right"></i>'
        }
    },
});
$('#apps2').DataTable({
    
    "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    "order": [
        [0, 'asc']
    ],
    "language": {
        "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
        "searchPlaceholder": "search",
        "paginate": {
            "previous": '<i class="fa fa-angle-left"></i>',
            "next": '<i class="fa fa-angle-right"></i>'
        }
    },
});
$('#apps3').DataTable({
    
    "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    "order": [
        [0, 'asc']
    ],
    "language": {
        "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
        "searchPlaceholder": "search",
        "paginate": {
            "previous": '<i class="fa fa-angle-left"></i>',
            "next": '<i class="fa fa-angle-right"></i>'
        }
    },
});
$('#apps4').DataTable({
    
    "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    "order": [
        [0, 'asc']
    ],
    "language": {
        "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
        "searchPlaceholder": "search",
        "paginate": {
            "previous": '<i class="fa fa-angle-left"></i>',
            "next": '<i class="fa fa-angle-right"></i>'
        }
    },
});
$('#apps5').DataTable({
    
    "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0
    }],
    "order": [
        [0, 'asc']
    ],
    "language": {
        "search": 'Enter any value for <span class="text-danger">LIVE</span> Search <i class="fa fa-search"></i>',
        "searchPlaceholder": "search",
        "paginate": {
            "previous": '<i class="fa fa-angle-left"></i>',
            "next": '<i class="fa fa-angle-right"></i>'
        }
    },
});
}

$('#targetSegment').change(function(e) {
    var t=$('#targetSegment').val();
    var targetSegment=$('#targetSegment').val();
    var productId=$('#productName').val();
    $('#productName').empty();
                $.ajax({
                                url: '/productName/'+t,
                                type: "GET",
                                dataType: "json",
                                success: function (data) {
                                    var str='<option> ---- Select Product ----</option>';
                                    str+='<option value="999"> ALL </option>'
                                    for(var i=0;i<data.length;i++){
                                     str+='<option value='+data[i].id+'>'+data[i].product+'</option>';
                                }
                                    $('#productName').prop("disabled", false);
                                    $('#productName').append(str);
                                }
                            });
});

$('#productName').change(function(e) {
var targetSegment=$('#targetSegment').val();
    var productId=parseInt($('#productName').val());
          $.ajax({
                url: '/populateApplications/'+targetSegment+'/'+productId,
                type: "GET",
                success: function (data) {
                    var str='';
                    var count=1;
                    for(var i=0;i<Object.keys(data).length;i++){
                      const dateObj =new Date(data[i].created_at);
                        const month = dateObj.getMonth()+1;
                        const day = String(dateObj.getDate()).padStart(2, '0');
                        const year = dateObj.getFullYear();
                        const output1 =  day + '/'+ month  + '/' + year;
                        
                        const dateObj2 =new Date(data[i].submitted_at);
                        const month2 = dateObj2.getMonth()+1;
                        const day2 = String(dateObj2.getDate()).padStart(2, '0');
                        const year2 = dateObj2.getFullYear();
                        const output2 =  day2 + '/'+ month2  + '/' + year2;
                        
                        var urlPreview='/admin/apps/preview/'+data[i].id;
                        var urlPrint='/admin/apps/print/'+data[i].id;
                        
                        str+='<tr><td>'+count+'</td><td>'+data[i].name+'</td><td>'+data[i].target_segment+'</td><td>'+data[i].app_no+'</td><td class="text-center">';
                        str+='<span class="text-success"><b>SUBMITTED</b></span></td>';
                        str+='<td>'+output1+'</td><td>'+output2+'</td>';
                        str+=' <td class="text-center"><a href="'+urlPreview+'" class="btn btn-info btn-sm btn-block"><i class="right fas fa-eye"></i></a>';
                        str+='<td class="text-center"><a href="'+urlPrint+'" class="btn btn-info btn-sm btn-block" target="_blank"><i class="fas fa-print"></i></a></td></tr>';
                 count=count+1;
                 }
                   
                  if ( $.fn.DataTable.isDataTable('#apps') )
                     {
                        $('#apps').DataTable().destroy();
                    }
                $('#apps tbody').empty();
                $('#apps').append(str);
                initialiseTable();
          
                }
                
                
            });


});
   

});

</script>
