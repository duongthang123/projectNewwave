@extends('admin.layouts.index')

@section('content')
    <div class="card-body">
        <h1>{{ __('message.Department List') }}</h1>
        @can('create-department')
            <div class="mb-2">
                <a href="{{ route('departments.create') }}" class="btn btn-primary">{{__('message.Create')}}</a>
            </div>
        @endcan
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>{{ __('message.Department Name') }}</th>
                    <th>{{ __('message.Department Description') }}</th>
                    <th style="width: 100px">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($departments as $department)
                    <tr>
                        <td> {{ $department->id }} </td>
                        <td> {{ $department->name }} </td>
                        <td> {{ $department->description }} </td>
                        <td>
                            @can('update-department')
                                <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete-department')
                                <button type="button" class="btn btn-sm btn-danger delete-button" data-toggle="modal" data-target="#modal-default"
                                    data-url="departments/{{ $department->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endcan
                        </td>
                @endforeach

            </tbody>
        </table>
        {{ $departments->appends(request()->query())->links() }}
        {{ Form::open(['route' => ['departments.index'], 'method' => 'GET', 'class' => 'mb-4']) }}
            <div class="row mt-4">
                <div class="col-md-1 ml-0">
                    {{ Form::select('per_page', config('const.PER_PAGE') , request('per_page'), 
                    [
                        'class' => 'form-control',
                        'onchange' => 'this.form.submit()'
                    ]) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
    @include('admin.layouts.confirm-delete')
@endsection

