@extends('layouts.normal')

@section('title', '双色球')

@section('body')
    <form method="POST" action="http://z3.la/bindmoblesms" accept-charset="UTF-8">
        <input type=text name=test value="1">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type=submit>

    </form>
    <input type="button" id="dosubmit" value="submit">
@stop

@section('script')
    require(['jquery'], function ($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $("#dosubmit").click(function(){
            $.ajax({
                url: '{{ URL('bindmoblesms', $parameters = [], $secure = null) }}',
                type: 'POST',
                dataType: 'JSON',
                data: {"_token":"{{ csrf_token() }}"},
                timeout: 5000,
                error: function() {
                },
                beforeSend: function() {
                },
                success: function(data) {
                    alert('ok');
                }
            });
        });
    });
@stop


