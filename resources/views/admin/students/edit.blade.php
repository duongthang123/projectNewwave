<div class="modal fade" id="modal-update-student" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="form-update-student" enctype="multipart/form-data">
            @csrf
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
                            <img src="" id="show-image-edit" width="200px" height="200px" alt="" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="student_code">Student Code</label>
                                <input type="text" disabled value="" class="form-control" id="student_code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_name">Name</label>
                                <input type="text" name="name" value="" class="form-control" id="student_name"
                                    placeholder="Enter student name...">
                                <span id="student_error_name" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_department">Department</label>
                                <select name="department_id" class="form-control" id="student_department">
                                        <option value=""></option>    
                                </select>
                                <span id="student_error_department" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_phone">Phone</label>
                                <input type="text" name="phone" value="" class="form-control" id="student_phone"
                                    placeholder="Enter student phone...">
                                <span id="student_error_phone" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_email">Email</label>
                                <input type="email" disabled name="email" value="" class="form-control" id="student_email"
                                    placeholder="Enter student email...">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_birthday">Birthday</label>
                                <input type="date" name="birthday" value="" class="form-control" id="student_birthday">
                                <span id="student_error_birthday" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_gender">Gender</label>
                                <select name="gender" class="form-control" id="student_gender">
                                    <option value="0">Male</option>
                                    <option value="1">Female</option>
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
                                            class="custom-control-input" id="status_studying" checked>
                                        <label for="status_studying" class="custom-control-label">Studying</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-3">
                                        <input type="radio" name="status" value="1"
                                            class="custom-control-input" id="status_stopped">
                                        <label for="status_stopped" class="custom-control-label">Stopped</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="status" value="2"
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
                <button type="button" id="update-button-student" onclick="event.preventDefault();updateStudent(this)" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@section('script')
    <script>
        $(() => {
            function readURL(input) {
                if(input.files && input.files[0]) {
                    var render = new FileReader();
                    render.onload = function (e) {
                        $('#show-image-edit').attr('src', e.target.result);
                        console.log(input.files[0].name);
                    };
                    render.readAsDataURL(input.files[0]);
                }
            }

            $('#image-input-edit').change(function () {
                readURL(this);
            });
        });
    </script>
    <script src="{{ asset('admin/assets/js/update-student.js') }}"></script>
@endsection
