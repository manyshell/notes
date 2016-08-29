
经测试，get应用于任何场景都能正常工作，但要指定好参数，参数不齐也会报错。
post方式时，不用指定具体的参数，例如下面这个，只有一句“testpost”。
    Route::get('aaa', 'testController@aaa');
    Route::post('testpost', 'testController@testpost');

为什么一直报500错误，提示VerifyCsrfToken.php出错？？？
原来是_token造成的，可参考test.blade.php，加上_token就可正常工作了


官方提供了一个通用解决方法：
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
前题是，需要在<head>之间加上此句，即可成功运行。
<meta name="csrf-token" content="{{ csrf_token() }}"/>
