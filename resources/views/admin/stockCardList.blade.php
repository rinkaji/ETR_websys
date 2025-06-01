<h1>This is stock card list</h1>

<ul>
    @foreach ($supplies as $supply)
    <li> <a href="">{{$supply->item}}</a> </li>
    @endforeach
</ul>