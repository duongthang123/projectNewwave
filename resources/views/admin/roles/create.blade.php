@extends('admin.layouts.index')

@section('title', 'Thêm Vai Trò')
@section('content')
    <div class="card-body">
        <h1>{{__('message.Add'). " " .__('message.Role')}}</h1>
        {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
            <div>
                <div class="form-group">
                    {!! Form::label('role_name', __('message.Role Name')) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'role_name', 'placeholder' => 'Nhập tên vai trò']) !!}
                    @error('name')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    {!! Form::label(__('message.Permission')) !!}
                    <div class="row">
                        @foreach ($permissions as $groupName => $permission)
                            <div class="col-4 mt-2">
                                <h4>{{$groupName}}</h4>

                                <div>
                                    @foreach ($permission as $item)
                                        <div class="form-check">
                                            {!! Form::checkbox('permission_ids[]', $item->id, false, ['class' => 'form-check-input', 'id' => 'customCheck1_'.$item->id]) !!}
                                            {!! Form::label('customCheck1_'.$item->id, $item->name, ['class' => 'form-check-label']) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                {!! Form::submit(__('message.Create'), ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{__('message.Back')}}</a>
            </div>
        {!! Form::close() !!}
    </div>
@endsection