<div class="modal fade" id="modal-update-result-student-{{$subject->id}}" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open([
                'id' => 'form-update-result-student-'.$subject->id.''
            ]) !!}
                <div class="modal-header">
                    <h5 class="modal-title">{{ $subject->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::label('score', 'Score') !!}
                    {!! Form::number('scores['.$subject->id.']', $subject->pivot->score, ['class' => 'form-control', 'id' => 'score', 'placeholder' => 'Enter score...', 'min' => '0', 'max' => '10']) !!}

                    <span id="result_error_score_{{ $subject->id }}" class="text-danger"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="event.preventDefault();updateResultStudent(`{{ route('students.update-student-result', $student->id)}}`,{{ $subject->id }})" class="btn btn-primary">Update</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>