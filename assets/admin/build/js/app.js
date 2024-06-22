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

    //UPDATE Coach STATUS
    $(document).on('click', '.updateCoachStatus', function() {
        var status = $(this).children('i').attr('status');
        var coach_id = $(this).attr('coach-id');
        
        $.ajax({
            type:'POST',
            url:'update-coach-status',
            data: {status: status, coach_id: coach_id},
            success:function(resp) {
                if (resp['status'] == 0) {
                    $('#coach-'+coach_id).html('<i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>');
                } else {
                    $('#coach-'+coach_id).html('<i class="fa fa-toggle-on" status="Active" title="Active"></i>');
                }
            }, error:function() {
                alert('Error');
            }
        });
    });

    //COACH IMAGE
    $(document).on('click', '#change-image', function() {
        if(!$('#photo').length) {
            $('#old-image').html('<input type="file" name="photo" id="photo" class="mt-2 ml-3" accept="image/*" />');
            $('#change-image').hide();
            $('#cancel-change').show();
        }
    });

    $(document).on('change', '#photo', function() {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#coach_image')
                    .attr('src', e.target.result)
                    .width(150);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on('click', '#cancel-change', function() {
        var image_url = $(this).attr('image-url');
        if($('#photo').length) {
            $('#old-image').html('');
            if(image_url == null) {
                $('#coach_image').attr('src', '../assets/admin/images/user.png');
            } else {
                $('#coach_image').attr('src', '../../assets/admin/upload/' + image_url);
            }
            $('#change-image').show();
            $('#cancel-change').hide();
        }
    });
});