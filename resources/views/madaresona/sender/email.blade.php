@extends('layouts.main')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Email Sender</b>
            </div>

            <div class="card-body">

                <form action="emailSender" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Title</label>
                            <input type="text" name="title" placeholder="Title" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Content</label>
                            <textarea name="email_content" id="email_content"
                                      placeholder="Content"></textarea>
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
        ClassicEditor.create(document.querySelector('#email_content'));
    </script>
    @endsection