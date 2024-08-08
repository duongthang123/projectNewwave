@extends('admin.layouts.index')

@section('content')
    <div class="card-body table-responsive">
        <h1>Student List</h1>
        <div class="row mb-2">
            <a href="{{ route('students.create') }}" class="btn btn-primary">{{__('message.Create')}}</a>
            <button class="btn btn-secondary ml-auto" data-toggle="modal" data-target="#modal-import-scores">
                <i class="fas fa-upload mr-2"></i>
                Import Score
            </button>
        </div>

        {{ Form::open(['route' => 'students.index', 'method' => 'GET', 'class' => 'mb-4']) }}
            <div class="row">
                <div class="col-md-1">
                    {{ Form::label('per_page', 'Per Page') }}
                    {{ Form::select('per_page', config('const.PER_PAGE') , request('per_page'), ['class' => 'form-control']) }}
                </div>
                <div class="col-md-1">
                    {{ Form::label('age_from', 'Age From') }}
                    {{ Form::number('age_from', request('age_from'), ['class' => 'form-control']) }}
                </div>
                <div class="col-md-1">
                    {{ Form::label('age_to', 'Age To') }}
                    {{ Form::number('age_to', request('age_to'), ['class' => 'form-control']) }}
                </div>
                <div class="col-md-1">
                    {{ Form::label('score_from', 'Score From') }}
                    {{ Form::number('score_from', request('score_from'), ['class' => 'form-control']) }}
                </div>
                <div class="col-md-1">
                    {{ Form::label('score_to', 'Score To') }}
                    {{ Form::number('score_to', request('score_to'), ['class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::label('phone_type', 'Phone Type') }}
                    {{ Form::select('phone_type', ['' => 'Select type phone'] + array_flip(config('const.PHONE_NUMBER_TYPE')), request('phone_type'), ['class' => 'form-control']) }}
                </div>
                <div class="col-md-2">
                    {{ Form::label('status', 'Status') }}
                    {{ Form::select('status', ['' => 'Select Status'] + array_flip(config('const.STUDENT_STATUS')), request('status'), ['class' => 'form-control']) }}
                </div>
                <div class="col-md-3 align-self-end">
                    {{ Form::submit('Search', ['class' => 'btn btn-primary']) }}
                </div>
            </div>
        {{ Form::close() }}

        <table class="table table-hover">
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th> Student Code</th>
                    <th> Name</th>
                    <th> Email</th>
                    <th> Gender</th>
                    <th> Birthday</th>
                    <th> Status</th>
                    <th> Created At</th>
                    <th> Subject </th>
                    <th style="width: 150px">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td> {{ $student->id }} </td>
                        <td> {{ $student->student_code }} </td>
                        <td> {{ $student->user->name }} </td>
                        <td> {{ $student->user->email }} </td>
                        <td> {{ $student->gender === config('const.GENDER.Male') ? "Male" : 'Female' }} </td>
                        <td> {{ $student->birthday }} </td>
                        <td> {!! \App\Helpers\UploadHelper::studenStatus($student->status) !!} </td>
                        <td> {{ $student->created_at }} </td>
                        <td>
                            <a href="{{ route('students.student-result', $student->id) }}" class="btn btn-secondary">
                                <span class="badge bg-secondary">{{ $student->subjectCount()}}</span>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-primary delete-button" data-toggle="modal" data-target="#modal-update-student"
                                onclick="editStudentById({{$student->id}})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-button" data-toggle="modal" data-target="#modal-default"
                                data-url="students/{{ $student->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                @endforeach

            </tbody>
        </table>
        {{ $students->appends(request()->query())->links() }}
    </div>
    @include('admin.layouts.confirm-delete')
    @include('admin.students.edit')
    @include('admin.includes.modal-import-scores')
@endsection