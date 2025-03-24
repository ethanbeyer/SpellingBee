You made it here!

<h1>All Words</h1>
<p>This set of letters contains {{ count($all_words) }} {{ Str::plural('word', count($all_words)) }}.</p>
<ul>
    @foreach($all_words->pluck('word') as $word)
        <li>{{ $word }}</li>
    @endforeach
</ul>

