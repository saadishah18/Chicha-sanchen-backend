<table class="table table-bordered table-active table-hover">
    <thead>
        <th>Name</th>
        <th>Price</th>
    </thead>
    <tbody>
    @foreach($values2 as $value)
        <tr>
            <td>{{$value->value}}</td>
            <td>{{$value->price}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
