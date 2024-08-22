@extends('admin.layouts.index')

@section('title', __('message.Show Student'))
@section('content')
    <div class="card-body">
        <h1>{{ __('message.Show Student') }}</h1>
        {!! Form::model($student) !!}
            <div>
                <div class="row">
                    <div class="col-md-6">

                        {!! Form::label('image-input', __('message.Image') )!!}
                        {!! Form::file('avatar', ['class' => 'form-control', 'disabled' => true, 'id' => 'image-input', 'accept' => 'image/*']) !!}
                    </div>

                    <div class="col-md-6">
                        <img src="{{ $student->avatar_url }}" id="show-image" style="width: 150px; height: 150px;" alt=""/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_name', __('message.Name') )!!}
                            {!! Form::text('name', $student->user->name, ['class' => 'form-control', 'disabled' => true, 'id' => 'student_name', 'placeholder' => 'Enter student name...']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_department', __('message.Department') )!!}
                            {!! Form::select('department_id', $departments, null, ['class' => 'form-control', 'disabled' => true, 'id' => 'student_department']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_phone', __('message.Phone') )!!}
                            {!! Form::text('phone', null, ['class' => 'form-control', 'disabled' => true, 'id' => 'student_phone', 'placeholder' => 'Enter student phone...']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_email', __('message.Email') )!!}
                            {!! Form::email('email', $student->user->email, ['class' => 'form-control', 'disabled' => true, 'id' => 'student_email', 'placeholder' => 'Enter student email...']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_birthday', __('message.Birthday') )!!}
                            {!! Form::date('birthday', null, ['class' => 'form-control', 'disabled' => true, 'id' => 'student_birthday']) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_gender', __('message.Gender') )!!}
                            {!! Form::select('gender', [0 => 'Male', 1 => 'Female'], null, ['class' => 'form-control', 'disabled' => true, 'id' => 'student_gender']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('student_address', __('message.Address') )!!}
                            {!! Form::text('address', null, ['class' => 'form-control', 'disabled' => true, 'id' => 'student_address']) !!}                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-2">
                            {!! Form::label('student_status', __('message.Status')) !!}
                            <div class="d-flex">
                                <div class="custom-control custom-radio mr-3">
                                    {!! Form::radio('status', 0, true, ['class' => 'custom-control-input', 'disabled' => true, 'id' => 'status_studying']) !!}
                                    {!! Form::label('status_studying', __('message.Studying'), ['class' => 'custom-control-label']) !!}
                                </div>
                                
                                <div class="custom-control custom-radio mr-3">
                                    {!! Form::radio('status', 1, false, ['class' => 'custom-control-input', 'disabled' => true, 'id' => 'status_stopped']) !!}
                                    {!! Form::label('status_stopped', __('message.Stopped'), ['class' => 'custom-control-label']) !!}
                                </div>
                                
                                <div class="custom-control custom-radio">
                                    {!! Form::radio('status', 2, false, ['class' => 'custom-control-input', 'disabled' => true, 'id' => 'status_expelled']) !!}
                                    {!! Form::label('status_expelled', __('message.Expelled'), ['class' => 'custom-control-label']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">{{__('message.Back')}}</a>
            </div>
        {!! Form::close() !!}
    </div>
@endsection