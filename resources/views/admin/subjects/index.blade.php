@extends('admin.layouts.index')

@section('content')
    <div class="card-body">
        <h1>Subject List</h1>
        <div class="mb-2">
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">{{__('message.Create')}}</a>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Subject Name</th>
                    <th>Subject Description</th>
                    <th style="width: 100px">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td> {{ $subject->id }} </td>
                        <td> {{ $subject->name }} </td>
                        <td> {{ $subject->description }} </td>
                        <td>
                            <a href="{{ route('subjects.edit', $subject->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger delete-button" data-toggle="modal" data-target="#modal-default"
                                data-url="subjects/{{ $subject->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                @endforeach

            </tbody>
        </table>
        {{ $subjects->appends(request()->only('key'))->links() }}
    </div>
    @include('admin.layouts.confirm-delete')
@endsection

