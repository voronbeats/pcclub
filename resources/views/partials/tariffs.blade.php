<div class="tariffs" data-tabs>
    <div class="tabs" role="tablist">
        @foreach (config('club.tariffs') as $t)
            <button type="button" class="tab" role="tab" data-tab="{{ $t['key'] }}">{{ $t['name'] }}</button>
        @endforeach
    </div>
    @foreach (config('club.tariffs') as $t)
        <div class="tpanel" data-panel="{{ $t['key'] }}">
            <p class="muted">{{ $t['note'] }}</p>
            <div class="trows">
                @foreach ($t['rows'] as $r)
                    <div class="trow @if ($r['hot']) trow--hot @endif"><span>{{ $r['t'] }}</span><b>{{ $r['p'] }}</b></div>
                @endforeach
            </div>
            <a class="btn" href="{{ route('book') }}?zone={{ $t['key'] }}">Забронировать {{ $t['name'] }}</a>
        </div>
    @endforeach
</div>
