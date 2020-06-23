
@if(isset($registration))
    <form action="{{ route('registration.update', $registration) }}" method="POST" id="registrationForm">
        {{ method_field('put') }}
        @else
<form action="{{ route('registration.store') }}" method="POST" id="registrationForm">
    @endif
    @csrf
    <div class="row">

        <div class="col-md-6 form-group">
            <label>Select Schools</label>
            <select name="schools[]" multiple="multiple" id="schools" class="form-control">
                @foreach($allSchools as $school)
                    <option value="{{ $school->id }}" @if(isset($registration) && in_array($school->id, $schoolsArray)) selected @endif>{{ $school->name_ar }}</option>
                @endforeach
            </select>

            <script>
                $('#schools').select2();
            </script>
        </div>

        <div class="col-md-6 form-group">
            <label>Select Class</label>
            <select name="class_id" id="class_id" class="form-control">
                @if(!isset($registration))
                    <option value="" selected disabled>Select Class</option>
                @endif

                @foreach($allClasses as $class)
                    <option value="{{ $class->id }}" @if(isset($registration) && $registration->class_id == $class->id) selected @endif>{{ $class->class_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>Parent</label>
            <input type="text" class="form-control" name="parent" placeholder="Parent" @if(isset($registration)) value="{{ $registration->parent }}" @endif>
        </div>

        <div class="col-md-4 form-group">
            <label>Phone Number</label>
            <input type="text" class="form-control" name="phone_number" placeholder="Phone Number" @if(isset($registration)) value="{{ $registration->number }}" @endif>
        </div>

        <div class="col-md-4 form-group">
            <label>Student</label>
            <input type="text" class="form-control" name="student" PLACEHOLDER="Student" @if(isset($registration)) value="{{ $registration->child }}" @endif>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <input type="submit" value="submit" id="submitBtn" class="btn btn-success" style="float: right">
        </div>
    </div>
</form>