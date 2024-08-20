@extends('admin.layouts.index')
@section('title', __('message.My Profile'))

@section('content')
    <div class="card-body">
        <h1></h1>
            <div>
                <div class="row mb-2">
                    <div class="col-md-12 d-flex align-items-center">
                        <img src="{{ $user->student->avatar_url }}" style="max-width: 200px; border-radius: 5px" alt=""/>
                        <div class="ml-3">
                            <h3 style="font-weight: 600"> {{ $user->name }}</h3>
                            <div class="d-flex">
                                <p class="mb-0 mr-3"><b>{{ __('message.Student Code') }}:</b> {{ $user->student->student_code }}</p>
                                <p class="mb-0 mr-3"><b>{{ __('message.Department') }}:</b>  {{ $user->student->department->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::open(['route' => 'students.update-profile', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row mt-4 mb-4 d-flex align-items-center">
                        <div class="col-md-1">
                            {!! Form::label('image-input', __('message.Image') )!!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'image-input', 'accept' => 'image/*']) !!}
                            @error('avatar')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            {!! Form::submit(__('message.Update') . ' ' . __('message.Image'), ['class' => 'btn btn-primary']) !!}
                        </div>
                        
                        <div class="col-md-6">
                            <img src="" id="show-image" style="border-radius: 5px" style="height: 150px;" width="150px" alt=""/>
                        </div>
                        
                    </div>
                {!! Form::close() !!}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_phone', __('message.Phone') )!!}
                            {!! Form::text('phone', $user->student->phone, ['class' => 'form-control', 'id' => 'student_phone', 'placeholder' => 'Enter student phone...', 'disabled' => true]) !!}
                            @error('phone')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_email', __('message.Email') )!!}
                            {!! Form::email('email', $user->email, ['class' => 'form-control', 'id' => 'student_email', 'placeholder' => 'Enter student email...', 'disabled' => true]) !!}
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_birthday', __('message.Birthday') )!!}
                            {!! Form::date('birthday', $user->student->birthday, ['class' => 'form-control', 'id' => 'student_birthday', 'disabled' => true]) !!}
    
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_gender', __('message.Gender') )!!}
                            {!! Form::select('gender', [0 => 'Male', 1 => 'Female'], $user->student->gender, ['class' => 'form-control', 'id' => 'student_gender', 'disabled' => true]) !!}
                    
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_address', __('message.Address') )!!}
                            {!! Form::text('address', $user->student->address, ['class' => 'form-control', 'id' => 'student_address', 'disabled' => true]) !!}                            
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            {!! Form::label('student_status', __('message.Status')) !!}
                            <div class="d-flex">
                                {!! \App\Helpers\UploadHelper::studenStatus($user->student->status) !!}
                            </div>
                            
                            @error('status')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('script')
    <script>
        $(() => {
            function readURL(input) {
                if(input.files && input.files[0]) {
                    var render = new FileReader();
                    render.onload = function (e) {
                        $('#show-image').attr('src', e.target.result);
                        console.log(input.files[0].name);
                    };
                    render.readAsDataURL(input.files[0]);
                }
            }

            $('#image-input').change(function () {
                readURL(this);
            });
        });
    </script>
@endsection