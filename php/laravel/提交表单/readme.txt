
�����ԣ�getӦ�����κγ�������������������Ҫָ���ò�������������Ҳ�ᱨ��
post��ʽʱ������ָ������Ĳ������������������ֻ��һ�䡰testpost����
    Route::get('aaa', 'testController@aaa');
    Route::post('testpost', 'testController@testpost');

Ϊʲôһֱ��500������ʾVerifyCsrfToken.php��������
ԭ����_token��ɵģ��ɲο�test.blade.php������_token�Ϳ�����������


�ٷ��ṩ��һ��ͨ�ý��������
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
ǰ���ǣ���Ҫ��<head>֮����ϴ˾䣬���ɳɹ����С�
<meta name="csrf-token" content="{{ csrf_token() }}"/>
