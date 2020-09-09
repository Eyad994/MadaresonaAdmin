@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <b>Sms Sender</b>
            </div>

            <div class="card-body">

                <form action="smsSender" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label>Number's</label>
                            <input type="file" name="title"  class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label style="display: block">Content</label>
                            <textarea name="sms_text" id="sms_text"
                                      placeholder="Text ........................" style="margin-top: 0px;
    margin-bottom: 0px;
    height: 200px;
    width: 800px;"></textarea>
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