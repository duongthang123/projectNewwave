$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.querySelectorAll('.delete-button').forEach(button => {
    button.addEventListener('click', function() {
        const url = this.getAttribute('data-url');
        document.getElementById('confirm-delete').setAttribute('data-url', '/' + url);
    });
})

document.getElementById('confirm-delete').addEventListener('click', function() {
    const url = this.getAttribute('data-url');
    removeUrl(url);
    $('#modal-default').modal('hide');
})

function removeUrl(url) {
    $.ajax({
        type: 'DELETE',
        url: url,
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result) {
            if(result.error === false) {
                const parts = url.split('/');
                window.location.href = '/' + parts[1];
            } else {
                location.reload();
            }
        }
    })
}

function editStudentById(id)
{
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: '/students/' + id + '/edit',
        success: function(result) {
            if (result.error === false) {
                var html = `
                    <div class="modal-header">
                        <h4 class="modal-title">Update Student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="image-input">Image</label>
                                    <input type="file" name="avatar" class="form-control" id="image-input-edit"
                                        accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <img src="${ result.studentThumb }" id="show-image-edit" width="200px" alt="" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="student_code">Student Code</label>
                                        <input type="text" disabled value="${ result.student.student_code }" class="form-control" id="student_code">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_name">Name</label>
                                        <input type="text" name="name" value="${ result.student.user.name }" class="form-control" id="student_name"
                                            placeholder="Enter student name...">
                                        <span id="student_error_name" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_department">Department</label>
                                        <select name="department_id" class="form-control" id="student_department">
                                            ${result.departments.data.map(department => `
                                                <option value="${department.id}" ${department.id === result.student.department_id ? 'selected' : ''}>${department.name}</option>    
                                            `).join('')}
                                        </select>
                                        <span id="student_error_department" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_phone">Phone</label>
                                        <input type="text" name="phone" value="${ result.student.phone }" class="form-control" id="student_phone"
                                            placeholder="Enter student phone...">
                                        <span id="student_error_phone" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_email">Email</label>
                                        <input type="email" disabled name="email" value="${ result.student.user.email }" class="form-control" id="student_email"
                                            placeholder="Enter student email...">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_birthday">Birthday</label>
                                        <input type="date" name="birthday" value="${ result.student.birthday }" class="form-control" id="student_birthday">
                                        <span id="student_error_birthday" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_gender">Gender</label>
                                        <select name="gender" class="form-control" id="student_gender">
                                            <option value="0" ${result.student.gender === 0 ? 'selected' : ''}>Male</option>
                                            <option value="1" ${result.student.gender === 1 ? 'selected' : ''}>Female</option>
                                        </select>
                                        <span id="student_error_gender" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_address">Address</label>
                                        <input type="text" name="address" value="${result.student.address}" class="form-control" id="student_address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-2">
                                        <label for="student_status">Status</label>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio mr-3">
                                                <input type="radio" name="status" value="0"
                                                    ${result.student.status === 0 ? 'checked' : ''}
                                                    class="custom-control-input" id="status_studying" checked>
                                                <label for="status_studying" class="custom-control-label">Studying</label>
                                            </div>
                                            <div class="custom-control custom-radio mr-3">
                                                <input type="radio" name="status" value="1"
                                                    ${result.student.status === 1 ? 'checked' : ''}
                                                    class="custom-control-input" id="status_stopped">
                                                <label for="status_stopped" class="custom-control-label">Stopped</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" name="status" value="2"
                                                    ${result.student.status === 2 ? 'checked' : ''}
                                                    class="custom-control-input" id="status_expelled">
                                                <label for="status_expelled" class="custom-control-label">Expelled</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="student_password">Password</label>
                                        <input type="password" name="password" class="form-control" id="student_password">
                                        <span id="student_error_password" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" onclick="event.preventDefault();updateStudent(${result.student.id})" class="btn btn-primary">Update</button>
                    </div>
                `;
                $('#form-update-student').html(html);
            }
        }
    })
}

function updateStudent(id)
{
    var formData = new FormData($('#form-update-student')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('_method', 'PUT');
    
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: '/students/' + id,
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
                errors.birthday ? $('#student_error_name').text(errors.birthday[0]) : '';
                errors.gender ? $('#student_error_gender').text(errors.gender[0]) : '';
                errors.password ? $('#student_error_password').text(errors.password[0]) : '';
            }
        }
    })
}

function updateResultStudent(url) 
{
    var formData = new FormData($('#form-update-result-student')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('_method', 'PUT');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if(result.error == false) {
                $('#modal-update-result-student').hide();
                location.reload();
            }
        },
        error: function(error) {
            if(error.status = 422) {
                var errors = error.responseJSON;
                errors.message ? $('#result_error_score').text(errors.message) : '';
            }
        }
    });
}

function updateMultiResultStudent(url)
{
    var formData = new FormData($('#form-update-multi-result-student')[0]);
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('_method', 'PUT');

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
            if(result.error == false) {
                $('#modal-multi-update-result-student').hide();
                location.reload();
            }
        },
        error: function(error) {
            if(error.status = 422) {
                var errors = error.responseJSON;
                $('#result-multi-error-score').text(errors.message);
            }
        }
    });
}