@extends('admin.layouts.index')
@section('title', __('message.Update Scores'))

@section('content')
    <div class="card-body">
        <h1>{{ __('message.Update Scores')}} </h1>
        <div class="row mb-2">
            <div class="col-md-8 d-flex align-items-center">
                <img src="{{ $student->avatar_url }}" id="show-image" style="max-width: 200px; border-radius: 5px" alt=""/>
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
                </tbody>

            </table>
            <button id="btn-submit-update-score" type="submit" class="btn btn-primary">{{ __('message.Update') }}</button>
        </form>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subjects = @json($student->subjects);
            const scoreUpdateBodyTable = document.getElementById('scores-table-body');
            const btnCreateNewRow = document.getElementById('create-row-update-score');
            const btnSubmitUpdate = document.getElementById('btn-submit-update-score');

            // get selected values
            function getSelectedValues() {
                const selectedValues = [];
                const selects = document.querySelectorAll('select');
                
                selects.forEach(select => {
                    if (select.value) {
                        selectedValues.push(select.value);
                    }
                });

                return selectedValues;
            }

            // Update options in selected form
            function updateOptions() {
                const selectedValues = getSelectedValues();
                const selects = document.querySelectorAll('select');
                
                selects.forEach(select => {
                    let options = '<option value="">Select Subject</option>';
                    
                    subjects.forEach(subject => {
                        if (!selectedValues.includes(subject.id.toString()) || select.value === subject.id.toString()) {
                            options += `<option value="${subject.id}" data-score="${subject.pivot.score}" ${select.value === subject.id.toString() ? 'selected' : ''}>${subject.name}</option>`;
                        }
                    });

                    select.innerHTML = options;
                });
            }

            // create new row update
            function createNewRow() {
                const selectedValues = getSelectedValues();
                const newRow = document.createElement('tr');

                let options = '<option value="">Select Subject</option>';

                subjects.forEach(subject => {
                    if(!selectedValues.includes(subject.id.toString())) {
                        options += `<option value="${subject.id}" data-score="${subject.pivot.score}">${subject.name}</option>`;
                    }
                })
                newRow.innerHTML = `
                    <td>
                        <div class="form-group">
                            <select class="custom-select">
                                ${options}
                            </select>
                            <span class="text-danger" style="display:none;"></span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number"  class="form-control" placeholder="Score">
                            <span class="text-danger" style="display:none;"></span>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove">
                            <i class="fas fa-minus"></i>
                        </button>
                    </td>
                `;
                const selectElement = newRow.querySelector('select');
                const inputElement = newRow.querySelector('input');
                const removeButton = newRow.querySelector('.btn-remove');

                selectElement.addEventListener('change', function() {
                    const selectedSubjectId = selectElement.value;
                    const selectedOption = selectElement.options[selectElement.selectedIndex];
                    const score = selectedOption.getAttribute('data-score');
                    
                    inputElement.name = `scores[${selectedSubjectId}]`;
                    inputElement.value = score;
                    updateOptions();
                });

                removeButton.addEventListener('click', function() {
                    newRow.remove();
                    updateOptions();
                });

                scoreUpdateBodyTable.appendChild(newRow);
            }

            // validate form 
            function validateForm() {
                let isValid = true;
                const inputs = document.querySelectorAll('input[name^="scores"]');
                const selects = document.querySelectorAll('select');
                
                // Validate form  inputs
                inputs.forEach(input => {
                    const value = parseFloat(input.value);
                    const errorElement = input.nextElementSibling;
                    if (isNaN(value) || value === '' || value < 0 || value > 10) {
                        isValid = false;
                        input.classList.add('is-invalid');
                        errorElement.textContent = 'Please ensure all scores are valid numbers between 0 and 10.';
                        errorElement.style.display = 'block';
                    } else {
                        input.classList.remove('is-invalid');
                        errorElement.style.display = 'none';
                    }
                });

                // Validate form select 
                selects.forEach(select => {
                    const feedbackElement = select.nextElementSibling;
                    if (select.value === '') {
                        isValid = false;
                        select.classList.add('is-invalid');
                        feedbackElement.textContent = 'Please select a subject.';
                        feedbackElement.style.display = 'block';
                    } else {
                        select.classList.remove('is-invalid');
                        feedbackElement.style.display = 'none';
                    }
                });
                return isValid;
            }

            // Check validate before sumit form
            btnSubmitUpdate.addEventListener('click', function () {
                if (!validateForm()) {
                    event.preventDefault();
                }
            })

            // Create new row
            btnCreateNewRow.addEventListener('click', function() {
                createNewRow();    
            })
            
        })
        
    </script>
@endsection