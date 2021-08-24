<nav id="navigation">
    <!-- container -->
    <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
            <!-- NAV -->
            <ul class="main-nav nav navbar-nav">
                <li @if(\Illuminate\Support\Facades\Request::is('/')) class="active"@endif>
                    <a href="/">Главная</a>
                </li>
                @foreach ($topCategories as $item)
                    <li @if(\Illuminate\Support\Facades\Request::is('catalog/' . $item->code)) class="active"@endif>
                        <a href="/catalog/{{$item->code}}">{{$item->name}}</a>
                    </li>
                @endforeach
            </ul>
            <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
    </div>
    <!-- /container -->
</nav>
