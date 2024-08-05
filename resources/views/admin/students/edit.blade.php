<div class="modal fade" id="modal-update-student" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg">
        <form class="modal-content" id="form-update-student" enctype="multipart/form-data">
            @csrf

        </form>
    </div>
</div>

@section('script')
    <script>
        $(() => {
            function readURL(input) {
                if(input.files && input.files[0]) {
                    var render = new FileReader();
                    render.onload = function (e) {
                        $('#show-image-edit').attr('src', e.target.result);
                        console.log(input.files[0].name);
                    };
                    render.readAsDataURL(input.files[0]);
                }
            }

            $('#image-input-edit').change(function () {
                readURL(this);
            });
        });
    </script>
@endsection
