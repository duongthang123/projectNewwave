@extends('admin.layouts.index')

@section('title', 'Update Department')

@section('content')
    <div class="card-body">
        <h1>Edit Department</h1>
        {!! Form::open(['route' => ['departments.update', $department->id], 'method' => 'PUT']) !!}
            <div>
                <div class="form-group">
                    {!! Form::label('department_name', 'Department Name') !!}
                    {!! Form::text('name', $department->name, ['class' => 'form-control', 'id' => 'department_name', 'placeholder' => 'Enter department name...']) !!}
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label('department_description', __('message.Department Description')) !!}
                    {!! Form::textarea('description', $department->description, ['class' => 'form-control', 'rows' => 4, 'id' => 'department_description']) !!}
                </div>
            </div>

            <div>
                {!! Form::submit(__('message.Update'), ['class' => 'btn btn-primary']) !!}
                <button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#modal-default"
                    data-url="departments/{{ $department->id }}">
                    {{__('message.Delete')}}
                </button>
                <a href="{{ route('departments.index') }}" class="btn btn-secondary">{{__('message.Back')}}</a>
            </div>
        {!! Form::close() !!}
    </div>
    @include('admin.layouts.confirmDelete')
@endsection