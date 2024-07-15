@if ($paginator->lastPage() > 1)
    <ul class="pagination">
        <li class="pagination__item{{ ($paginator->currentPage() == 1) ? ' pagination__item--disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->currentPage() - 1) }}" class="pagination__link">
                <svg width="512" height="512" viewBox="0 0 512 512" style="color:currentColor" xmlns="http://www.w3.org/2000/svg" class="h-full w-full"><rect width="512" height="512" x="0" y="0" rx="30" fill="transparent" stroke="transparent" stroke-width="0" stroke-opacity="100%" paint-order="stroke"></rect><svg width="512px" height="512px" viewBox="0 0 24 24" fill="currentColor" x="0" y="0" role="img" style="display:inline-block;vertical-align:middle" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 4l-8 8l8 8"/></g></svg></svg>
            </a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="pagination__item{{ ($paginator->currentPage() == $i) ? ' pagination__item--active' : '' }}">
                <a href="{{ $paginator->url($i) }}" class="pagination__link">{{ $i }}</a>
            </li>
        @endfor
        <li class="pagination__item{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' pagination__item--disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->currentPage() + 1) }}" class="pagination__link">
                <svg width="512" height="512" viewBox="0 0 512 512" style="color:currentColor" xmlns="http://www.w3.org/2000/svg" class="h-full w-full"><rect width="512" height="512" x="0" y="0" rx="30" fill="transparent" stroke="transparent" stroke-width="0" stroke-opacity="100%" paint-order="stroke"></rect><svg width="512px" height="512px" viewBox="0 0 24 24" fill="currentColor" x="0" y="0" role="img" style="display:inline-block;vertical-align:middle" xmlns="http://www.w3.org/2000/svg"><g fill="currentColor"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 4l8 8l-8 8"/></g></svg></svg>
            </a>
        </li>
    </ul>
@endif