<div class="modal fade" id="modal-update-multi-register-subjects" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open([
                'method' => 'PUT',
                'route' => ['students.register-subjects-update', $student->id]
            ]) !!}
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center"> Are you sure resgiter?</h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div id="modal-body-register-multi-subjects" class="modal-body">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>