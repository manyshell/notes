1、cd /usr/ports/lang/php5
2、make install clean
3、出现了个对话框，这个要选上，DEBUG不用选。
Options for php5 5.2.1_3
[X] CLI        Build CLI version
[X] CGI        Build CGI version
[X] APACHE     Build Apache module
[X] SUHOSIN    Enable Suhosin protection system
[X] IPV6       Enable ipv6 support
[X] FASTCGI    Enable fastcgi support (CGI only)
[X] PATHINFO   Enable path-info-check support (CGI only)
实际上，就只增加一项(3)APACHE。
4、cd /usr/ports/lang/php5-extensions
5、make install clean
6、配置模块，这几个需要自己选上
[X] CURL CURL support
[X] EXIF EXIF support	这个新增，也是处理图片的
[X] FTP FTP support
[X] GD GD library support
[X] MBSTRING    multibyte string support
[X] MING (flash专用)
[X] MYSQL MySQL database support
[X] PDF PDFlib support (implies GD)
[X] SOCKETS     sockets support
Options for curl 7.19.7_1
默认选项
Options for php5-gd 5.1.6
[X] T1LIB Include T1lib support
[X] TRUETYPE Enable TrueType string function
# PHP 下的精簡型文字資料庫 Text Database
Options for php5-sqlite 5.1.6 
[X] UTF8 Enable UTF-8 support
7、extensions安装完成，至此
LoadModule php5_module libexec/apache22/libphp5.so等模块已经自动添加到apache的httpd.conf中去了。
8、ee /usr/local/etc/apache22/httpd.conf
第356行添加(让apache支持php)
AddType application/x-httpd-php .php
AddType application/x-httpd-php-source .phps
第217行屏掉"#"
#	DirectoryIndex index.html
第213行添加(让apache以php为主)
     DirectoryIndex index.php index.htm index.html index.html.var
第195行屏掉"#"
#    Options Indexes FollowSymLinks
第196行添加(让apache在没有目录的时候不显示)
     Options FollowSymLinks
第148行屏掉"#"
#ServerName www.test.com:80
第155行屏掉"#"
DocumentRoot "/usr/local/www/apache22/data"

9、
cd /usr/local/etc/
cp php.ini-dist php.ini
vi php.ini
10、ee /usr/local/etc/php.ini
第428行不用改，已默认
register_globals =Off	#不允许直接使用变量
第1044行
session.gc_maxlifetime = 7200	#3600一小时，7200相当于2小时

11、测试成功就结束了php的安装
<?
phpinfo();
?>
FreeBSD下安装PHP5时有pdo选项，但这样还不能使用pdo_mysql，php会提示：Connection failed: could not find driver.
需另外安装php5-pdo_mysql：
cd /usr/ports/databases/php5-pdo_mysql
make install clean

安装php-oracle支持
/usr/ports/databases/php52-oci8
