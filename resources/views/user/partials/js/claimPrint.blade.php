<script>
    function printPage() {
        var divfy = document.getElementById('FY');
        var div0 = document.getElementById('applicantdetail');
        var div1 = document.getElementById('salesdetails');
        var div2 = document.getElementById('dvadetails');
        var div3 = document.getElementById('investmentdetail');
        var div4 = document.getElementById('projectdetail');
        var div5 = document.getElementById('rptdetails');
        var div6 = document.getElementById('uploadA');
        var div7 = document.getElementById('uploaddetails');
        var div8 = document.getElementById('tx');
        var newWin = window.open('', 'Print-Window');

        newWin.document.open();
        newWin.document.write('<html><head><title></title>');
            newWin.document.write('<link href="{{ asset("css/app.css") }}" rel="stylesheet">');
            newWin.document.write('<link href="{{ asset("css/app/preview.css") }}" rel="stylesheet">');
            newWin.document.write(
                '<style>@media print { .pagebreak { clear: both; page-break-before: always; }}</style>');
            newWin.document.write('</head><body onload="window.print()">');
        newWin.document.write(divfy.innerHTML);  
        newWin.document.write(div0.innerHTML);       
        newWin.document.write(div1.innerHTML);
        newWin.document.write(div2.innerHTML);
        newWin.document.write(div3.innerHTML);
        newWin.document.write(div4.innerHTML);
        newWin.document.write(div5.innerHTML);
        newWin.document.write(div6.innerHTML);
        newWin.document.write(div7.innerHTML);
        newWin.document.write(div8.innerHTML);
        newWin.document.close();
    };
</script>

