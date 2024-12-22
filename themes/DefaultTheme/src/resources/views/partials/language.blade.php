@if (option('multi_language_enabled', false))
    <li class="Language px-0 ms-2 d-flex align-items-center">
        @if (app()->getLocale() == 'en')
            <a class="mx-1 d-flex align-items-center" href="javascript:void(0)">
              <span class="ml-2">en</span><img src="{{ theme_asset('img/us.jpg') }}" alt="English">
            </a>
        @elseif(app()->getLocale() == 'tr')
            <a class="mx-1 d-flex align-items-center" href="javascript:void(0)">
              <span class="ml-2">tr</span><img src="{{ theme_asset('img/tr.svg') }}" alt="turkey">
            </a>

        @else
            <a class="mx-1 d-flex align-items-center" href="javascript:void(0)">
                <span class="ml-2">fa</span><img src="{{ theme_asset('img/ir.jpg') }}" alt="English">
            </a>
        @endif
        <div class="dropdown">
            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ url('/fa') }}"><img class="px-1 flage_lang" src="{{ theme_asset('img/ir.jpg') }}" alt="Germany">Persian</a>
                <a class="dropdown-item" href="{{ url('/en') }}"><img class="px-1 flage_lang" src="{{ theme_asset('img/us.jpg') }}" alt="English">English </a>
                <a class="dropdown-item" href="{{ url('/tr') }}"><img class="px-1 flage_lang" src="{{ theme_asset('img/tr.svg') }}" alt="English">Turkey </a>
            </div>
        </div>
    </li>
@endif
