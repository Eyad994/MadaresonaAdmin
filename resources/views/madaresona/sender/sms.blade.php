@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Sms Sender</b>
            </div>

            <div class="card-body">
                <form id="smsSenders" action="{{ route('smsSenders') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Number's</label>
                            <input type="file" name="phones" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label style="display: block">Content</label>
                            <textarea name="sms_text" id="sms_text"
                                      placeholder="Text ........................"
                                      style="margin-top: 0px; margin-bottom: 0px; height: 200px;width: 800px;"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="submit" class="btn btn-success" name="Submit" style="float: right">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $('#smsSenders').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    if (data.status === 422) {
                        var error_html = '';
                        for (let value of Object.values(data.errors)) {
                            error_html += '<div class="alert alert-danger">' + value + '</div>';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: error_html,
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                    }
                }
            });


        });
    </script>
@endsection