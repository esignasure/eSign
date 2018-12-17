@extends('layouts.main')
@section('title', 'My Documents')
@section('content')
    <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
    <div id="app">
        <documents></documents>
    </div>
@stop
