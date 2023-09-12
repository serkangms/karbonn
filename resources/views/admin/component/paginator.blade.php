@php $paginator->appends(request()->except('page')); @endphp
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link"  style="color: #BD1D1D;font-weight: 600;"  tabindex="-1">Geri</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" style="color: #BD1D1D;font-weight: 600;"  href="{{ $paginator->previousPageUrl() }}">Geri</a>
            </li>
        @endif

        {{-- Display links to specific pages --}}
        @php
            $maxPagesToShow = 4;
            if ($paginator->lastPage() < $maxPagesToShow) {
                $maxPagesToShow = $paginator->lastPage();
            }
            $middlePage = ceil($maxPagesToShow / 2);
            $startPage = $paginator->currentPage() - $middlePage + 1;
            $endPage = $startPage + $maxPagesToShow - 1;

            if ($startPage < 1) {
                $startPage = 1;
                $endPage = $startPage + $maxPagesToShow - 1;
            }

            if ($endPage > $paginator->lastPage()) {
                $endPage = $paginator->lastPage();
                $startPage = $endPage - $maxPagesToShow + 1;
            }

            if ($startPage > 1) {
                echo '<li class="page-item"><a class="page-link" style="color: #BD1D1D;font-weight: 600;"  href="' . $paginator->url(1) . '">1</a></li>';
                if ($startPage > 2) {
                    echo '<li class="page-item disabled"><a style="color: #BD1D1D;font-weight: 600;"  class="page-link" >...</a></li>';
                }
            }

            for ($page = $startPage; $page <= $endPage; $page++) {
                if ($page == $paginator->currentPage()) {
                    echo '<li class="page-item active"><a class="page-link border-danger" style="background-color: #BD1D1D;font-weight: 600;" >' . $page . '</a></li>';
                } else {
                    echo '<li class="page-item"><a style="color: #BD1D1D;font-weight: 600;" class="page-link" href="' . $paginator->url($page) . '">' . $page . '</a></li>';
                }
            }

            if ($endPage < $paginator->lastPage()) {
                if ($endPage < $paginator->lastPage() - 1) {
                    echo '<li class="page-item disabled"><a style="color: #BD1D1D;font-weight: 600;"  class="page-link" href="#">...</a></li>';
                }
                echo '<li class="page-item"><a class="page-link" style="color: #BD1D1D;font-weight: 600;"  href="' . $paginator->url($paginator->lastPage()) . '">' . $paginator->lastPage() . '</a></li>';
            }
        @endphp

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" style="color: #BD1D1D;font-weight: 600;"  href="{{ $paginator->nextPageUrl() }}" rel="next">İleri</a>
            </li>
        @endif
    </ul>
</nav>
