@foreach ($cars as $car)
    <tr>
        <td>{{$car->make}}</td>
        <td>{{$car->model}}</td>
        <td>{{$car->milleage}}</td>
    </tr>
@endforeach