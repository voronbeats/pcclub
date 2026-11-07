<div class="faq">
    @foreach (config('club.faq') as $f)
        <details>
            <summary>{{ $f['q'] }}</summary>
            <p>{{ $f['a'] }}</p>
        </details>
    @endforeach
</div>
