<script>
$(document).ready(function () {
    $("#finalSubmit").click(function (event) {
        event.preventDefault();
        var link = $(this).attr('href');
        swal({
                title: "No Change is allowed in Committed Capacity, Quoted Price and Committed Investment. Are you sure to submit the form?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                closeOnClickOutside: false,
            })
            .then((value) => {
                if (value) {
                    window.location.href = link;
                }
            });
    });
});

 function printPage() {
   // alert("mjhjk");
    var div1 = document.getElementById('complete_form');
    var newWin = window.open('', 'Print-Window');
  
    newWin.document.open();
    newWin.document.write('<html><head><title></title>');
        newWin.document.write('<link href="{{ asset("css/app.css") }}" rel="stylesheet">');
        newWin.document.write('<link href="{{ asset("css/app/preview.css") }}" rel="stylesheet">');
        newWin.document.write(
            '<style>@media print { .pagebreak { clear: both; page-break-before: always; } }</style>');
        newWin.document.write('</head><body onload="window.print()">');
    newWin.document.write(div1.innerHTML);
    newWin.document.close();
};

</script>
