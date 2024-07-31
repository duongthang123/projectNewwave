@extends('admin.layouts.index')

@section('title', 'Cập Nhật Vai Trò')
@section('content')
    <div class="card-body">
        <h1>{{__('message.Edit'). " " .__('message.Role')}}</h1>
        {!! Form::open(['route' => ['roles.update', $role->id], 'method' => 'PUT']) !!}
            <div>
                <div class="form-group">
                    {!! Form::label('role_name', __('message.Role Name')) !!}
                    {!! Form::text('name', old('name') ?? $role->name, ['class' => 'form-control', 'id' => 'role_name', 'placeholder' => 'Nhập tên vai trò']) !!}
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
                                            {!! Form::checkbox('permissions_id[]', $item->id, $role->permissions->contains('name', $item->name), ['class' => 'form-check-input', 'id' => 'customCheck1_'.$item->id]) !!}
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
                {!! Form::submit(__('message.Update'), ['class' => 'btn btn-primary']) !!}
                <button type="button" class="btn btn-danger delete-button" data-toggle="modal" data-target="#modal-default"
                    data-url="roles/{{ $role->id }}">
                    {{__('message.Delete')}}
                </button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">{{__('message.Back')}}</a>
            </div>
        {!! Form::close() !!}
    </div>
    @include('admin.layouts.confirmDelete')
@endsection