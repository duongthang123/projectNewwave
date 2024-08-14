@extends('admin.layouts.index')
@section('title', __('message.Transcript'))

@section('content')
    <div class="card-body">
        <h1>{{ __('message.Transcript') }}</h1>
        <div class="row mb-2">
            <div class="col-md-8 d-flex align-items-center">
                <img src="{{ $student->avatar_url }}" id="show-image" style="max-width: 200px; border-radius: 5px" alt=""/>
                <div class="ml-3">
                    <h4 style="font-weight: 600"> {{ $student->user->name }}</h4>
                    <div class="d-flex">
                        <p class="mb-0 mr-3">{{ __('message.Student Code')}}: {{ $student->student_code }}</p>
                        <p class="mb-0 mr-3">{{ __('message.Email')}}: {{ $student->user->email }}</p>
                        <p class="mb-0 mr-3">{{ __('message.Phone')}}: {{ $student->phone }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-2">
                    @can('register-subject')
                        <a href="{{ route('students.register-subjects', $student->id) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            {{ __('message.Register Subjects') }}
                        </a>
                    @endcan
                </div>
                <div class="mt-4">
                    <p class="text-danger" style="font-size: 20px">
                        <b>
                           {{ __('message.Average Score')}}: {{ number_format($avgScore, 2) }}
                        </b>
                    </p>
                </div>
            </div>
        </div>
        @hasrole('admin')
            <div class="row mt-6 mr-2">
                <div class="ml-auto">
                    <a class="btn btn-warning" id="update-result-btn" style="display: none;max-width: 140px"
                        data-toggle="modal" data-target="#modal-update-muti-result-student"
                    >
                        <i class="fas fa-edit"></i>
                        {{ __('message.Update result') }}
                    </a>
                </div>
            </div>
        @endhasrole
        
        @hasrole('admin')
            <div class="row mt-6 mr-2">
                <div class="ml-auto">
                    <a href="{{ route('students.edit-scores', $student->id) }}" class="btn btn-primary"
                    >
                        <i class="fas fa-edit"></i>
                        {{ __('message.Update result') }}
                    </a>
                </div>
            </div>
        @endhasrole

        <table class="table table-hover table-bordered mt-4">
            <thead>
                <tr>
                    <th style="width: 50px;"></th>
                    <th style="width: 50px;">ID</th>
                    <th>{{ __('message.Subject Name') }}</th>
                    <th>{{ __('message.Score')}}</th>
                    <th style="width: 100px">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($student->subjects as $subject)
                    <tr>
                        <td>
                            @hasrole('admin')
                                <input type="checkbox" class="subject-checkbox" value="{{ $subject->id }}"
                                    data-score="{{ $subject->pivot->score }}" data-name="{{ $subject->name}}">
                            @endhasrole
                        </td>
                        <td> {{ $subject->id }} </td>
                        <td> {{ $subject->name }} </td>
                        <td> {{ $subject->pivot->score }} </td>
                        <td>
                            @hasrole('admin')
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-update-result-student-{{$subject->id}}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @include('admin.includes.update-result-student')
                                @include('admin.includes.update-muti-result-student')
                            @endhasrole
                        </td>
                @endforeach
                        
            </tbody>
        </table>
    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.subject-checkbox');
        const updateResultBtn = document.getElementById('update-result-btn');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                updateResultBtn.style.display = anyChecked? 'block' : 'none';
            })
        })

        updateResultBtn.addEventListener('click', function() {
            const modalBodyUpdate = document.getElementById('modal-body-update-muti-result');
            modalBodyUpdate.innerHTML = '';

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const subjectName = checkbox.getAttribute('data-name');
                    const score = checkbox.getAttribute('data-score');
                    const subjectId = checkbox.value;

                    const subjectInfo = `
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="score-input-${subjectId}" class="mt-2">${subjectName}</label>
                            </div>
                            <div class="col-md-4">
                                <input type="number" id="score-input-${subjectId}" name="scores[${subjectId}]" min="0" max="10" class="form-control" value="${score}">
                            </div>
                        </div>
                    `;
                    
                    modalBodyUpdate.insertAdjacentHTML('beforeend', subjectInfo);
                }
            })

        })
    });
</script>
@endsection
