<script>
    $(document).ready(function () {
     $( document ).ajaxStart(function() {
     $( "#loading" ).show();
     });
 
     $( document ).ajaxStop(function() {
     $( "#loading" ).hide();
     });
     initialiseTable();
     function initialiseTable()
     {
         $('#apps').DataTable({
             "iDisplayLength":25,
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
             "iDisplayLength":25,
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
             "iDisplayLength":25,
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
 });
 </script>
 