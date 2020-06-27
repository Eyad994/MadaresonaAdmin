@if(isset($sale))
    <form action="{{ route('sale.update', $sale) }}" method="POST" id="saleForm">
        {{ method_field('PUT') }}
        @else
            <form action="{{ route('sale.store') }}" method="POST" id="saleForm">
                @endif
                @csrf

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label>User</label>
                        <select name="user_id" class="form-control">
                            @if(!isset($sale))
                                <option selected disabled>Select User</option>
                            @endif
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                        @if(isset($sale) && $sale->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="date">Date :</label>
                        <input name="date" id="datepicker" value="{{ $sale->date->format('m-yy') }}" class="date-picker form-control"/>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Department</label>
                        <select name="department" class="form-control">
                            @if(!isset($sale))
                                <option selected disabled>Select Department</option>
                            @endif
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}"
                                        @if(isset($sale) && $sale->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Target</label>
                        <input type="text" name="target" class="form-control" placeholder="Target"
                               @if(isset($sale)) value="{{ $sale->target }}" @endif>
                    </div>
                </div>
                <div class="col-md-12 form-group">
                    <input type="submit" value="Submit" class="btn btn-success" style="float: right;">
                </div>
            </form>

            <script type="text/javascript">

                $(function () {
                    $("#datepicker").datepicker({
                        format: "mm-yyyy",
                        startView: "months",
                        minViewMode: "months"
                    });
                });

            </script>