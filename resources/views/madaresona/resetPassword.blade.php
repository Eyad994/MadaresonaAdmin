<style>
    .input-group-addon {
        padding: .5rem .75rem;
        padding-top: 18px;
        width: 50px;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.25;
        color: #495057 !important;
        text-align: center;
        background-color: #e9ecef;
        border: 1px solid rgba(0,0,0,.15);
        border-radius: 0px .25rem .25rem 0px;
    }
</style>
<form action="{{ route('updatePassword') }}" method="POST" id="resetPassForm">
    {{ method_field('PUT') }}
    @csrf
    <div class="row">
        <div class="col-md-6 form-group">
            <label>New Password</label>
            <div class="input-group" id="show_hide_password">
                <input type="password" class="form-control" name="new_password" placeholder="New Password">
                <div class="input-group-addon">
                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 form-group">
            <label>Confirm Password</label>
            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
        </div>
        <div class="col-md-12 form-group">
            <input type="submit" value="Submit" class="btn btn-success" style="float: right">
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
    });
</script>