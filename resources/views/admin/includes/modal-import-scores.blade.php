<div class="modal fade" id="modal-import-scores" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {!! Form::open([
                'method' => 'POST',
                'route' => 'students.import-scores',
                'enctype' => 'multipart/form-data'
            ]) !!}
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center"> {{ __('message.Chose File') }} </h5>
                    
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="file" name="file">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('message.Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('message.Upload') }}</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>