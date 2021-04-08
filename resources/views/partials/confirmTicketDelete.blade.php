@section('content')
    @parent

    <div class="modal fade" id="confirm-close" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Confirm Ticket Close</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>You are about to close ticket, this procedure is irreversible.</p>
                    <p>Do you want to proceed?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btnCloseTicket">Do it!</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function () {
            $('#status').on('change', function (){
                let status = $(this).val();
                let url = new URL(window.location);
                (url.searchParams.has('status') ? url.searchParams.set('status', status) : url.searchParams.append('status', status));
                (url.searchParams.has('page') ? url.searchParams.set('page', '1') : null);
                window.location = url;
            });
            $('#confirm-close').on('shown.bs.modal', function (e) {
                e.preventDefault();
                let $target = $(e.relatedTarget);
                let url = $target.data('url');
                $(this).one('click', '.btnCloseTicket', function(e) {
                    e.preventDefault();
                    let $modalDiv = $(e.delegateTarget);
                    let $this = $(this);
                    $this.prop("disabled", true);
                    $this.html(
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
                    );

                    $.ajax({
                        type: 'POST',
                        url: url,
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        success: function (data){
                            $this.html('Do it!');
                            $this.prop("disabled", false);
                            $modalDiv.modal('hide');
                            $target.addClass('hide');
                            if(data.success){
                                toastr.success(data.msg);
                                $target.addClass('d-none');
                                setTimeout(window.location.reload.bind(window.location), 1250);
                            }else{
                                toastr.error(data.msg);
                            }
                        },
                        error:function (){
                            $this.closest('.modal').find('.modal-body').html('<p class="">Unknown error has occurred. Please try again.</p>');
                        }
                    });
                    return false;
                });
            });

        });
    </script>
@endpush
