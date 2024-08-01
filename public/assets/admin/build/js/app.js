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

    //UPDATE CHAT ROOM STATUS
    $(document).on('click', '.updateRoomStatus', function() {
        var status = $(this).children('i').attr('status');
        var room_id = $(this).attr('room-id');
        
        $.ajax({
            type:'POST',
            url:'update-room-status',
            data: {status: status, room_id: room_id},
            success:function(resp) {
                if (resp['status'] == 0) {
                    $('#room-'+room_id).html('<i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>');
                } else {
                    $('#room-'+room_id).html('<i class="fa fa-toggle-on" status="Active" title="Active"></i>');
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

    //UPDATE PATIENT STATUS
    $(document).on('click', '.updatePatientStatus', function() {
        var status = $(this).children('i').attr('status');
        var patient_id = $(this).attr('patient-id');
        
        $.ajax({
            type:'POST',
            url:'update-patient-status',
            data: {status: status, patient_id: patient_id},
            success:function(resp) {
                if (resp['status'] == 0) {
                    $('#patient-'+patient_id).html('<i class="fa fa-toggle-off" status="Inactive" title="Inactive"></i>');
                } else {
                    $('#patient-'+patient_id).html('<i class="fa fa-toggle-on" status="Active" title="Active"></i>');
                }
            }, error:function() {
                alert('Error');
            }
        });
    });

    //SEARCH PAITIENT BY NAME
    $(document).on('input', '#searchPName', function(e) {
        makeSearch();
    });

    $(document).on('input', '#searchUID', function(e) {
        makeSearch();
    });

    $(document).on('input', '#searchPhone', function(e) {
        makeSearch();
    });

    $(document).on('change', '#searchGender', function(e) {
        makeSearch();
    });

    $(document).on('change', '#searchCoach', function(e) {
        makeSearch();
    });

    $(document).on('click', '#searchPagination a', function(e) {
        e.preventDefault();
        var searchPName = $('#searchPName').val();
        var searchUID = $('#searchUID').val();
        var searchPhone = $('#searchPhone').val();
        var searchGender = $('#searchGender').val();
        var searchCoach = $('#searchCoach').val();
        var url = $(this).attr('href');
        var token = $('#searchToken').val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: {
                searchPName: searchPName,
                '_token': token,
                searchUID: searchUID,
                searchPhone: searchPhone,
                searchGender: searchGender,
                searchCoach: searchCoach
            },
            success: function(data) {
                $('#ajaxSearchDiv').html(data);
            }, error: function() {

            }
        });
    });

    function makeSearch() {
        var searchPName = $('#searchPName').val();
        var searchUID = $('#searchUID').val();
        var searchPhone = $('#searchPhone').val();
        var searchGender = $('#searchGender').val();
        var searchCoach = $('#searchCoach').val();
        var url = $('#searchUrl').val();
        var token = $('#searchToken').val();

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            cache: false,
            data: {
                searchPName: searchPName,
                '_token': token,
                searchUID: searchUID,
                searchPhone: searchPhone,
                searchGender: searchGender,
                searchCoach: searchCoach
            },
            success: function(data) {
                $('#ajaxSearchDiv').html(data);
            }, error: function() {
                alert('Error');
            }
        });
    }

    //CALCULATE BODY MASS INDEX WITH WEIGHT
    $(document).on('input', '#pWeight', function() {
        var height = $('#pHeight').val();
        
        var weight = $(this).val();

        if(height != "") {
            var bmi = weight / ((height/100) * (height/100));
            $('#bmi').val(bmi.toFixed(2));
        } else {
            return false;
        }
    });

    //SHOW WEIGHT TEXT @ UPDATE PARAMETERS
    $(document).on('click', '.weightEditLink', function() {
        var row_id = $(this).attr('row-id');
        $(this).hide();
        $('#weightSpan-' + row_id).hide();
        $('#pWeight-' + row_id).show();
        $('#weightSaveLink-' + row_id).show();
        $('#weightCancelLink-' + row_id).show();
    });

    //HIDE WEIGHT TEXT @ UPDATE PARAMETERS
    $(document).on('click', '.weightCancelLink', function() {
        var row_id = $(this).attr('row-id');
        $(this).hide();
        $('#weightSpan-' + row_id).show();
        $('#pWeight-' + row_id).hide();
        $('#weightSaveLink-' + row_id).hide();
        $('#weightEditLink-' + row_id).show();
    });

    //SAVE WEIGHT & BMI @ UPDATE PARAMETERS
    $(document).on('click', '.weightSaveLink', function() {
        var row_id = $(this).attr('row-id');
        var weight = $('#pWeight-' + row_id).val();
        var height = $(this).attr('height-data');
        var patient_id = $(this).attr('patient');
        var age = $(this).attr('age');
        var gender = $(this).attr('gender');

        if(weight == null || weight == '') {
            alert('Please enter a weight value.');
            return false;
        } else {
            $.ajax({
                type:'POST',
                url:'/admin/update-weight',
                data: {row_id: row_id, weight: weight, height: height, patient_id: patient_id},
                success:function(resp) {
                    $(this).hide();
                    $('#weightSpan-'+ row_id).html('<span id="weightSpan-' + row_id + '">' + resp['weight'] + '</span>');
                    $('#bmiSpan-'+ row_id).html('<span id="bmiSpan-' + row_id + '">' + resp['bmi'] + '</span>');
                    $('#bmiAvg').html('<span id="bmiAvg">' + resp['avg_bmi'] + '</span>')
                    if(gender == 'M') {
                        $('#mFatAvg').html('<span id="mFatAvg">' + Number((1.20 * + resp['avg_bmi']) + (0.23 * age) - 16.2).toFixed(2) + '%</span>');
                    } else if(gender == 'F') {
                        $('#fFatAvg').html('<span id="fFatAvg">' + Number((1.20 * + resp['avg_bmi']) + (0.23 * age) - 5.4).toFixed(2) + '%</span>');
                    }
                    $('#weightSpan-' + row_id).show();
                    $('#pWeight-' + row_id).hide();
                    $('#weightSaveLink-' + row_id).hide();
                    $('#weightCancelLink-' + row_id).hide();
                    $('#weightEditLink-' + row_id).show();
                }, error:function() {
                    alert('Error');
                }
            });
        }
    });

    //SHOW RBS TEXT @ UPDATE PARAMETERS
    $(document).on('click', '.rbsEditLink', function() {
        var row_id = $(this).attr('row-id');
        $(this).hide();
        $('#rbsSpan-' + row_id).hide();
        $('#pRbs-' + row_id).show();
        $('#rbsSaveLink-' + row_id).show();
        $('#rbsCancelLink-' + row_id).show();
    });

    //HIDE RBS TEXT @ UPDATE PARAMETERS
    $(document).on('click', '.rbsCancelLink', function() {
        var row_id = $(this).attr('row-id');
        $(this).hide();
        $('#rbsSpan-' + row_id).show();
        $('#pRbs-' + row_id).hide();
        $('#rbsSaveLink-' + row_id).hide();
        $('#rbsEditLink-' + row_id).show();
    });

    //SAVE RBS @ UPDATE PARAMETERS
    $(document).on('click', '.rbsSaveLink', function() {
        var row_id = $(this).attr('row-id');
        var rbs = $('#pRbs-' + row_id).val();

        if(rbs == null || rbs == '') {
            alert('Please enter RBS Value');
            return false;
        } else {
            $.ajax({
                type:'POST',
                url:'/admin/update-rbs',
                data: {row_id: row_id, rbs: rbs},
                success:function(resp) {
                    $(this).hide();
                    $('#rbsSpan-'+ row_id).html('<span id="rbsSpan-' + row_id + '">' + resp['rbs'] + '</span>');
                    $('#rbsSpan-' + row_id).show();
                    $('#pRbs-' + row_id).hide();
                    $('#rbsSaveLink-' + row_id).hide();
                    $('#rbsCancelLink-' + row_id).hide();
                    $('#rbsEditLink-' + row_id).show();
                }, error:function() {
                    alert('Error');
                }
            });
        }
    });

    //SHOW SYSTOLIC & DISTOLIC TEXT @ UPDATE PARAMETERS
    $(document).on('click', '.bpEditLink', function() {
        var row_id = $(this).attr('row-id');
        $(this).hide();
        $('#bpSysSpan-' + row_id).hide();
        $('#pSys-' + row_id).show();
        $('#bpDisSpan-' + row_id).hide();
        $('#pDis-' + row_id).show();
        $('#bpSaveLink-' + row_id).show();
        $('#bpCancelLink-' + row_id).show();
    });

    //HIDE SYSTOLIC & DISTOLIC TEXT @ UPDATE PARAMETERS
    $(document).on('click', '.bpCancelLink', function() {
        var row_id = $(this).attr('row-id');
        $(this).hide();
        $('#bpSysSpan-' + row_id).show();
        $('#pSys-' + row_id).hide();
        $('#bpDisSpan-' + row_id).show();
        $('#pDis-' + row_id).hide();
        $('#bpSaveLink-' + row_id).hide();
        $('#bpEditLink-' + row_id).show();
    });

    //SAVE SYSTOLIC & DISTOLIC @ UPDATE PARAMETERS
    $(document).on('click', '.bpSaveLink', function() {
        var row_id = $(this).attr('row-id');
        var sys = $('#pSys-' + row_id).val();
        var dis = $('#pDis-' + row_id).val();
        var patient_id = $(this).attr('patient');

        if(sys == null || sys == '') {
            alert('Please enter a systolic value.');
            return false;
        } else if (dis == null || dis == '') {
            alert('Please enter a distolic value.');
            return false;
        } else {
            $.ajax({
                type:'POST',
                url:'/admin/update-bp',
                data: {row_id: row_id, sys: sys, dis: dis, patient_id: patient_id},
                success:function(resp) {
                    $(this).hide();
                    $('#bpSysSpan-'+ row_id).html('<span id="bpSysSpan-' + row_id + '">' + resp['sys'] + '</span>');
                    $('#bpDisSpan-'+ row_id).html('<span id="bpDisSpan-' + row_id + '">' + resp['dis'] + '</span>');
                    $('#heartRate').html('<span id="heartRate">' + (((resp['avg_sys'] - resp['avg_dis']) * 1.6) + 80).toFixed() + ' bpm</span>');
                    $('#bpAvg').html('<span id="bpAvg">' + Number(resp['avg_sys']).toFixed()  + ' / ' + Number(resp['avg_dis']).toFixed() + ' mm Hg</span>');
                    $('#bpSysSpan-' + row_id).show();
                    $('#pSys-' + row_id).hide();
                    $('#bpDisSpan-' + row_id).show();
                    $('#pDis-' + row_id).hide();
                    $('#bpSaveLink-' + row_id).hide();
                    $('#bpCancelLink-' + row_id).hide();
                    $('#bpEditLink-' + row_id).show();
                }, error:function() {
                    alert('Error');
                }
            });
        }
    });

    //GET COMPLEX NAME @ TRANSFER PATIENT
    $(document).on('change', '#coach_name', function() {
        var selected = $(this).find('option:selected');
        var coach_id = selected.attr('value')

        $.ajax({
            type:'POST',
            url:'/admin/get-complex',
            data: {coach_id: coach_id},
            success:function(resp) {
                $('#complex').val(resp['complex']);
            }, error:function() {
                alert('Error');
            }
        });
    });
});