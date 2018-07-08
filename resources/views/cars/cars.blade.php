<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    {!! Form::open(array('action' => 'CarsController@index', 'method' => 'get')) !!}
    <div class="form-group">
    {!! Form::select('cars', [null => 'Please select', 'active' => \App\Cars::pluck('make', 'make')],  array('class' => 'form-control')) !!}
    </div>
    <table id="cars">
        <tbody>
        @foreach ($cars as $car)
            <tr>
                <td>{{$car->make}}</td>
                <td>{{$car->model}}</td>
                <td>{{$car->milleage}}</td>
                <td>{{$car->feature}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="form-group">
        {!! Form::label('result', 'Milleage') !!}
        {!! Form::radio('result', 'milleage'), old('milleage') == 'milleage' !!}

        {!! Form::label('result', 'Make') !!}
        {!! Form::radio('result', 'make', old('make') == 'make') !!}

        {!! Form::label('result', 'Model') !!}
        {!! Form::radio('result', 'model', old('model') == 'model') !!}
    </div>
    <div class="form-group">
        @foreach($features as $feature)
            {!! Form::label('feature',$feature->feature) !!}
            {!! Form::checkbox('feature',trim($feature->feature), old(trim($feature->feature)) == trim($feature->feature)) !!}
            @endforeach

    </div>
    <div class="form-group">
        {!! Form::submit('Click Me!') !!}
    </div>

    {!! Form::close() !!}
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script>
    $("select[name='cars']").on('change', function() {
        var make = $(this).val();
        var host = "{{URL::to('/')}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: host + '/cars/filter',
            data: {make: make, _token: '{{csrf_token()}}'},
            success: function(response) {
                $("#cars tbody").html(response);

            },
            error: function (data, textStatus, errorThrown) {
                console.log(data);

            },
        })
    })
</script>

</body>
</html>