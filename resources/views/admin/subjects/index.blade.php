@extends('admin.layouts.index')

@section('content')
    <div class="card-body">
        <h1>Subject List</h1>
        <div class="mb-2">
            <a href="{{ route('subjects.create') }}" class="btn btn-primary">{{__('message.Create')}}</a>
        </div>
        <div class="row mt-6 mr-2">
            <div class="ml-auto">
                <a class="btn btn-warning" id="update-register-subject-btn" style="display: none;max-width: 140px"
                    data-toggle="modal" data-target="#modal-update-multi-register-subjects"
                >
                    <i class="fas fa-plus"></i>
                    Resgister All
                </a>
            </div>
        </div>
        <table class="table table-hover table-bordered mt-2">
            <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <th style="width: 50px;">ID</th>
                    <th>Subject Name</th>
                    <th>Subject Description</th>
                    <th style="width: 100px">&nbsp;</th>
                    <th style="width: 100px">Register</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        {{-- @can('register-subject') --}}
                        <td>
                            @if (Auth::user()->student)
                                @php 
                                    $student = Auth::user()->student;
                                    $subjectStudent = $student->subjects->pluck('id')->toArray();
                                @endphp
                                @if (!in_array($subject->id, $subjectStudent))
                                    <input type="checkbox" class="register-subject-checkbox" value="{{ $subject->id }}"
                                        data-name="{{ $subject->name }}">
                                @endif
                            @endif
                        </td>
                        {{-- @endcan --}}
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
                        <td class="text-center">
                            @if (Auth::user()->student)
                                @php 
                                    $student = Auth::user()->student;
                                    $subjectStudent = $student->subjects->pluck('id')->toArray();
                                @endphp
                                @if (!in_array($subject->id, $subjectStudent))
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-update-register-subjects-{{$subject->id}}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    @include('admin.includes.update-register-subjects')
                                    @include('admin.includes.update-multi-register-subjects')
                                @endif
                            
                            @endif
                        </td>
                @endforeach

            </tbody>
        </table>
        {{ $subjects->appends(request()->query())->links() }}
        {{ Form::open(['route' => ['subjects.index'], 'method' => 'GET', 'class' => 'mb-4']) }}
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
