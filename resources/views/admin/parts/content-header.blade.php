<!-- Content Header (Page header) -->
<div class="content-header pb-0">
    <div class="container-fluid pl-0">
        <div class="row mb-2">
            <div class="col-sm-5">
                <h1 class="m-0">
                    @isset($url_back)
                        <a href="{{ $url_back }}" class="btn btn-flat btn-secondary"><i
                                    class="fa fa-chevron-left"></i> </a>
                    @endif
                    @isset($page_title) {!! $page_title !!} @endisset
                    @isset($small_page_title)<small>{!! $small_page_title !!}</small>@endisset
                    @if(!empty($url_create))
                        <a href="{{ $url_create }}" class="btn btn-flat btn-success"><i class="fa fa-plus"></i> Create</a>
                    @endif
                </h1>
            </div>
            <div class="col-sm-7">
                <div class="float-sm-right">
                    @if($btn_search ?? false)
                        <div class="content-header-search">
                            {!! Lte3::formOpen(['action' => Request::fullUrl(), 'method' => 'GET']) !!}
                            <div class="input-group">
                                <input type="search" value="{{ request('q') }}" name="q" class="form-control">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default btn-flat"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                            {!! Lte3::formClose() !!}
                        </div>
                    @endif

                    @if(isset($btn_filter) && $btn_filter)
                        @if(is_array($btn_filter))
                            <div class="btn-group">
                                <a href="#collapseFilter" class="btn btn-flat btn-default mb-1" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseFilter"><i class="fa fa-filter"></i></a>
                                <button type="button" class="btn btn-flat btn-default mb-1 dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                    @foreach($btn_filter as $btn)
                                        <a class="dropdown-item" href="{{$btn['url']}}">{{$btn['title']}}</a>
                                    @endforeach
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ Request::url() }}">Clear</a>
                                </div>
                            </div>
                        @else
                            <a href="#collapseFilter" class="btn btn-flat btn-default mb-1" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseFilter"><i class="fa fa-filter"></i></a>
                        @endif
                    @endif

                    @yield('btn-content-header')
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.parts.callouts')
@include('admin.parts.alerts')
