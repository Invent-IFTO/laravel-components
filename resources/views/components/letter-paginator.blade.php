<ul class="pagination">
    @foreach(range('A', 'Z') as $letter)
        <li class="page-item {{ $selected == $letter ? 'active' : '' }}">
            <a class="page-link" href="{{ request()->fullUrlWithQuery(['letter' => $letter,'page'=>1]) }}">{{ $letter }}</a>
        </li>
    @endforeach
</ul>