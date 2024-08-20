$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function editStudentById(id) {
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/students/' + id + '/edit',
        success: function(result) {
            if (result.error === false) {
                console.log(result.departments);

                $('#student_code').val(result.student.student_code);
                $('#student_name').val(result.student.user.name);
                $('#student_phone').val(result.student.phone);
                $('#student_email').val(result.student.user.email);
                $('#student_birthday').val(result.student.birthday);
                $('#student_gender').val(result.student.gender);
                $('#student_address').val(result.student.address);

                $('input[name="status"][value="' + result.student.status + '"]').prop('checked', true);

                $('#show-image-edit').attr('src', result.studentThumb);

                $('#update-button-student').attr('data-id', id);

                $('#student_department').empty();
                $.each(result.departments.data, function(index, department) {
                    $('#student_department').append(
                        `<option value="${department.id}" ${department.id === result.student.department_id ? 'selected' : ''}>${department.name}</option>`
                    );
                });

                $('#modal-update-student').modal('show');
            }
        }
    });
}


function updateStudent(button)
{
    const studentId = button.getAttribute('data-id')

    var formData = new FormData($('#form-update-student')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('_method', 'PUT');
    
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/students/' + studentId,
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if(result.error == false) {
                $('#modal-update-student').hide();
                location.reload();
            }
        },
        error: function(error) {
            if(error.status = 422) {
                var errors = error.responseJSON.errors;
                errors.name ? $('#student_error_name').text(errors.name[0]) : '';
                errors.phone ? $('#student_error_phone').text(errors.phone[0]) : '';
                errors.department ? $('#student_error_department').text(errors.department[0]) : '';
                errors.birthday ? $('#student_error_birthday').text(errors.birthday[0]) : '';
                errors.gender ? $('#student_error_gender').text(errors.gender[0]) : '';
                errors.password ? $('#student_error_password').text(errors.password[0]) : '';
            }
        }
    })
}