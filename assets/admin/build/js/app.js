$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //UPDATE COMPLEX STATUS
    $(document).on('click', '.updateComplexStatus', function() {
        var status = $(this).children('i').attr('status');
        var complex_id = $(this).attr('complex-id');
        
        $.ajax({
            type:'POST',
            url:'update-complex-status',
            data: {status: status, complex_id: complex_id},
            success:function(resp) {
                if (resp['status'] == 0) {
                    $('#complex-'+complex_id).html('<i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>');
                } else {
                    $('#complex-'+complex_id).html('<i class="fa fa-toggle-on" status="Active" title="Active"></i>');
                }
            }, error:function() {
                alert('Error');
            }
        });
    });
});