@if(isset($user))
    <form action="{{ route('user.update', $user) }}" method="POST" id="userForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('user.store') }}" method="POST" id="userForm">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name"
                               @if(isset($user)) value="{{ $user->name }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email"
                               @if(isset($user)) value="{{ $user->email }}" @endif>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Phone</label>
                        <input type="number" class="form-control" name="phone" placeholder="Phone"
                               @if(isset($user)) value="0{{ $user->phone }}" @endif>
                    </div>
                    @if(!isset($user))
                        <div class="col-md-6 form-group">
                            <label>Type</label>
                            <select name="type" class="form-control">
                                @if(!isset($user))
                                    <option disabled>Select Type</option>
                                @endif
                                <option value="1" @if(isset($user) && $user->type == 1) selected @endif>Admin</option>
                                <option value="3" @if(isset($user) && $user->type == 3) selected @endif>Editor</option>
                            </select>
                        </div>
                    @endif
                    <div class="col-md-6 form-group">
                        <label>Active</label>
                        <select name="active" class="form-control">
                            <option value="0" @if(isset($user) && $user->type == 0) selected @endif>False</option>
                            <option value="1" @if(isset($user) && $user->type == 1) selected @endif>True</option>
                        </select>
                    </div>
                    <div class="col-md-12 form-group">
                        <input type="submit" value="Submit" class="btn btn-success" style="float: right">
                    </div>
                </div>
            </form>