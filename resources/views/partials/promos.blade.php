<div class="grid grid--2">
    @foreach (config('club.promos') as $p)
        <article class="promo">
            <span class="badge">{{ $p['badge'] }}</span>
            <h3>{{ $p['title'] }}</h3>
            <p>{{ $p['text'] }}</p>
        </article>
    @endforeach
</div>
