<style>
    .pagination {
    display: flex;
    padding-left: 0;
    list-style: none;
    border-radius: .25rem;
    }
    .pagination li.active>span {
    z-index: 3;
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
    }
    .pagination li a,span {
    position: relative;
    display: block;
    padding: .5rem .75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #007bff;
    background-color: #fff;
    border: 1px solid #dee2e6;
    }
</style>
<script src="<?= asset('') ?>assets/frontend/js/jquery.min.js"></script>
<ul>
@foreach ($listContent as $value)
<li>
<h3><a href="{{asset('').Helper::create_slug($value->title).'-'.$value->id.'.html'}}">{{Helper::CutText($value->title,60)}}</a>
<small class="datetime pull-right"> {{ date('d/m',strtotime($value->created)) }} </small></h3>
<img src="{{Helper::getImageDetail( $value->thumbnail, $category_id )}}" title="image">
<p> {{Helper::CutText( strip_tags( $value->content ) , 400 )}} </p>
<a href="{{asset('').Helper::create_slug($value->title).'-'.$value->id.'.html'}}">Chi tiết</a>
</li>
@endforeach
</ul>
@php
    $paginator=$listContent;
@endphp
@if ($paginator->lastPage() > 1)
    <!-- si la pagina actual es distinto a 1 muestra el boton de atras -->
    @if($paginator->currentPage() != 1)
        <li>
            <a href="{{ $paginator->url($paginator->currentPage()-1) }}" >
                <
            </a>
        </li>
    @endif

    <!-- dibuja las hojas... Tomando un rango de 5 hojas, siempre que puede muestra 2 hojas hacia atras y 2 hacia adelante -->
    <!-- I draw the pages... I show 2 pages back and 2 pages forward -->
    @for($i = max($paginator->currentPage()-2, 1); $i <= min(max($paginator->currentPage()-2, 1)+4,$paginator->lastPage()); $i++)
            <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
            </li>
    @endfor

    <!-- si la pagina actual es distinto a la ultima muestra el boton de adelante -->
    <!-- if actual page is not equal last page then I show the forward button-->
    @if ($paginator->currentPage() != $paginator->lastPage())
        <li>
            <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >
                >
            </a>
        </li>
    @endif

    <!-- si la pagina actual es distinto a la ultima y hay mas de 5 hojas muestra el boton de ultima hoja -->
    <!-- if actual page is not equal last page, and there is more than 5 pages then I show last page button -->
    @if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() >= 5)
        <li>
            <a href="{{ $paginator->url($paginator->lastPage()) }}" >
                >>
            </a>
        </li>
    @endif
</ul>