@extends('admin.layouts.index')

@section('title', 'Thêm Khoa')
@section('content')
    <div class="card-body">
        <h1>{{__('message.Add'). " " .__('message.Department')}}</h1>
        {!! Form::open(['route' => 'departments.store', 'method' => 'POST']) !!}
            <div>
                <div class="form-group">
                    {!! Form::label('department_name', __('message.Department Name')) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'department_name', 'placeholder' => 'Nhập tên khoa']) !!}
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('department_description', __('message.Department Description')) !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4, 'id' => 'department_description']) !!}
                </div>
            </div>

            <div>
                {!! Form::submit(__('message.Create'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">{{__('message.Back')}}</a>
            </div>
        {!! Form::close() !!}
    </div>
@endsection