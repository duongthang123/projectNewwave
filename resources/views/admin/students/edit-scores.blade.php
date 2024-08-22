@extends('admin.layouts.index')
@section('title', __('message.Update Scores'))

@section('content')
    <div class="card-body">
        <h1>{{ __('message.Update Scores')}} </h1>
        <div class="row mb-2">
            <div class="col-md-8 d-flex align-items-center">
                <img src="{{ $student->avatar_url }}" id="show-image" style="max-width: 100px; max-height:100px; border-radius: 5px" alt=""/>
                <div class="ml-3">
                    <h4 style="font-weight: 600"> {{ $student->user->name }}</h4>
                    <div class="d-flex">
                        <p class="mb-0 mr-3">{{ __('message.Student Code') }}: {{ $student->student_code }}</p>
                        <p class="mb-0 mr-3">Email: {{ $student->user->email }}</p>
                        <p class="mb-0 mr-3">{{ __('message.Phone')}}: {{ $student->phone }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        
        <div class="row mt-6 mr-2">
            <div class="ml-auto">
                <button id="create-row-update-score" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    {{ __('message.Create')}}
                </button>
            </div>
        </div>

        <form action="{{ route('students.update-student-scores', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="table table-hover table-bordered mt-4">
                <thead>
                    <tr>
                        <th>{{ __('message.Subject Name') }} </th>
                        <th>{{ __('message.Score') }} </th>
                        <th style="width: 100px">&nbsp;</th>
                    </tr>
                </thead>

                <tbody id="scores-table-body">
                    @if (session('form_data'))
                        @foreach (session('form_data') as $subjectId => $score)
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <select class="custom-select subject-select">
                                            @foreach ($subjects as $item)
                                                <option value="{{ $item->id }}" 
                                                    {{ $item->id == $subjectId ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has("subjects.$loop->index"))
                                            <span class="text-danger">
                                                {{ $errors->first("subjects.$loop->index") }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="scores[{{ $subjectId }}]" 
                                            value="{{ $score }}" placeholder="Score">
                                        <span class="text-danger">
                                            {{ session('errors')->first("scores.$subjectId") }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-remove">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($student->subjects as $subject)
                            @if (isset($subject->pivot->score))
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="custom-select subject-select">
                                                @foreach ($subjects as $item)
                                                    <option value="{{ $item->id }}" 
                                                        {{ $item->id === $subject->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="scores[{{ $subject->id }}]" 
                                                value="{{ $subject->pivot->score }}" placeholder="Score">
                                            <span class="text-danger">
                                                {{ $errors->first("scores.$subject->id") }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-remove">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
            <button id="btn-submit-update-score" style="display: none"  type="submit" class="btn btn-primary">{{ __('message.Update') }}</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        window.subjects = @json($subjects);
        window.studentSubjects = @json($student->subjects);
    </script>
    <script src="{{ asset('admin/assets/js/update-student-score.js')}}"></script>
@endsection