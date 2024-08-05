@extends('admin.layouts.index')

@section('content')
    <div class="card-body">
        <h1>{{ __('message.Role List') }}</h1>
        <div class="mb-2">
            <a href="{{ route('roles.create') }}" class="btn btn-primary">{{__('message.Create')}}</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>{{ __('message.Role Name') }}</th>
                    <th style="width: 100px">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td> {{ $role->id }} </td>
                        <td> {{ $role->name }} </td>
                        <td>
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-button" data-toggle="modal" data-target="#modal-default"
                                data-url="roles/{{ $role->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                @endforeach

            </tbody>
        </table>
        {{ $roles->appends(request()->only('key'))->links() }}
    </div>
    @include('admin.layouts.confirm-delete')
@endsection

