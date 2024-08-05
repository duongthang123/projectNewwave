<div class="modal fade" id="modal-update-muti-result-student" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Score</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {!! Form::open([
                'id' => 'form-update-multi-result-student'
            ]) !!}
                <div class="ml-3">
                    <p id="result-multi-error-score" style="margin:8px 0" class="text-danger"></p>
                </div>
                <div id="modal-body-update-muti-result" class="modal-body">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" 
                    onclick="event.preventDefault();updateMultiResultStudent(`{{ route('students.update-student-result', $student->id)}}`)" class="btn btn-primary">Update</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>