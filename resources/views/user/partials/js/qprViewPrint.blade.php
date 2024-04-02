<script>
    function printPage() {
    var div1 = document.getElementById('qrrTabContent');
    var div2 = document.getElementById('revenueTabContent');
    var div3 = document.getElementById('ppTabContent');
    var div4 = document.getElementById('uploadTabContent');
    var div5 = document.getElementById('approvalTab');
    var div6 = document.getElementById('datetime');
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write('<html><head><title></title>');
        newWin.document.write('<link href="{{ asset("css/app.css") }}" rel="stylesheet">');
        newWin.document.write('<link href="{{ asset("css/app/preview.css") }}" rel="stylesheet">');
        newWin.document.write(
            '<style>@media print { .pagebreak { clear: both; page-break-before: always; } }</style>');
        newWin.document.write('</head><body onload="window.print()">');
    newWin.document.write(div1.innerHTML);
    newWin.document.write(div2.innerHTML);
    newWin.document.write(div3.innerHTML);
    newWin.document.write(div4.innerHTML);
    newWin.document.write(div5.innerHTML);
    newWin.document.write(div6.innerHTML);
    newWin.document.close();
};
</script>
