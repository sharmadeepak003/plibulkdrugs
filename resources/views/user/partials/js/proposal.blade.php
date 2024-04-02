<script>
    $(document).ready(function () {

        $('#prod_date').on("keyup change", function (e) {
            var dateString = $(this).val();
            var myDate = new Date(dateString);
            var today = new Date();
            if (myDate < today) {
                alert("Date can't be less than today's date");
                $('#prod_date').val('');
                return false;
            }
            return true;

        });


    });

</script>
