<script>
    function printPage() {
        var div0 = document.getElementById('Name');
       
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><title></title>');
        newWin.document.write('<link href="{{ asset('css/app.css') }}" rel="stylesheet">');
        newWin.document.write('<style>.card-header{font-size:15px;}</style>');
        newWin.document.write('<link href="{{ asset('css/app/preview.css') }}" rel="stylesheet">');
        newWin.document.write(
            '<style>@media print { .pagebreak { clear: both; page-break-before: always; } }</style>');
        newWin.document.write('</head><body onload="window.print()">');
        //newWin.document.write(div0ToPrint.innerHTML);
        newWin.document.write(div0.innerHTML);
        newWin.document.write(div1.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div2.innerHTML);
        newWin.document.write('</body></html>');
        newWin.document.write(div3.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div4.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div5.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');

        newWin.document.write(div7.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div8.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');

        newWin.document.write(div9.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div10.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div11.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');

        newWin.document.write(div13.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div14.innerHTML);
        newWin.document.write('<div class="pagebreak"></div>');
        newWin.document.write(div15.innerHTML);

        newWin.document.write('<div class="pagebreak"></div>');

        newWin.document.close();
    };
</script>
