<div class="modal fade" id="modal-update-register-subjects-{{$subject->id}}" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open([
                'id' => 'form-update-result-student',
                'method' => 'PUT',
                'route' => ['students.register-subjects-update', $student->id]
            ]) !!}
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center"> Are you sure resgiter?</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"> 
                    <span>{{ $subject->id }} - </span>
                    <span>{{ $subject->name }}</span>
                    {!! Form::hidden('subject_ids['.$subject->id.']', $subject->id) !!}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>