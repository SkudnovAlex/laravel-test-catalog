@extends('shop.layout')

@section('content')
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- shop -->
            <div class="col-md-4 col-xs-6">
                @if ($subCategory)
                <ul class="list-categories">
                    @foreach($subCategory as $category)
                        <li><a href="{{$category->code}}/list">{{$category->name}}</a></li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
