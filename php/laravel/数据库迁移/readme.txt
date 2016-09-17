执行数据库迁移
Laravel version 5.1+

Migrations把表结构存储为一个PHP类，通过调用其中的方法来创建、更改数据库。Migrations存放在 database/migrations 目录中。
通常情况下，有两个默认文件。
/database/migrations/2014_10_12_000000_create_users_table.php
/database/migrations/2014_10_12_100000_create_password_resets_table.php

获得帮助
>php artisan make:migration -h
Usage:
  make:migration [options] [--] <name>

Arguments:
  name                   The name of the migration.

Options:
      --create[=CREATE]  The table to be created.
      --table[=TABLE]    The table to migrate.
      --path[=PATH]      The location where the migration file should be created
.
  -h, --help             Display this help message
  -q, --quiet            Do not output any message
  -V, --version          Display this application version
      --ansi             Force ANSI output
      --no-ansi          Disable ANSI output
  -n, --no-interaction   Do not ask any interactive question
      --env[=ENV]        The environment the command should run under.
  -v|vv|vvv, --verbose   Increase the verbosity of messages: 1 for normal output
, 2 for more verbose output and 3 for debug

Help:
 Create a new migration file
----------------------------------------------------------------------------------------------------------------------------------
--create    是创建一个新表
--table     为修改指定表
----------------------------------------------------------------------------------------------------------------------------------
php artisan migrate
执行所有未执行的迁移
注意: 如果在执行迁移时发生「class not found」错误，试着先执行 composer dump-autoload 命令后再进行一次。
理论上是把/database/migrations/下的所有迁移文件都执行一遍。
----------------------------------------------------------------------------------------------------------------------------------
php artisan migrate --force
在线上环境 (Production) 中强制执行迁移
有些迁移操作是具有破坏性的，意味着可能让你遗失原本保存的数据。
为了防止你在上线环境执行到这些迁移命令，你会被提示要在执行迁移前进行确认。加上 --force 参数执行强制迁移。
----------------------------------------------------------------------------------------------------------------------------------
php artisan migrate:rollback
回滚上一次的迁移
----------------------------------------------------------------------------------------------------------------------------------
php artisan migrate:reset
回滚所有迁移
----------------------------------------------------------------------------------------------------------------------------------
php artisan migrate:refresh
php artisan migrate:refresh --seed
回滚所有迁移并且再执行一次
----------------------------------------------------------------------------------------------------------------------------------
>php artisan make:migration create_articles_table --create=articles
 
Created Migration: 2015_05_11_140813_create_articles_table
创建一个存放博客的数据表[articles]
此时， database/migrations 目录中会多出一个***_create_articles_table.php文件
----------------------------------------------------------------------------------------------------------------------------------
php artisan make:migration add_excerpt_to_articles_table --table=articles
给表中增加一个excerpt字段，我们可以执行回滚，然后修改原来的文件再执行迁移

php artisan migrate:make add_email_to_authors_table
在表中添加“email”列。先使用artisan创建新的迁移文件：
然后编辑2014_03_12_051119_add_email_to_authors_table.php文件，添加电子邮件列。
我们使用Schema::table()方法，有两个参数：表名、闭包函数（在此函数内添加字段）。
public function up()
{
        Schema::table('authors', function($table) {
                $table ->string('email', 64);
        });
}

public function down()
{
        Schema::table('authors', function($table) {
                $table ->dropColumn('email');
        });
}

以上两种方法都没有经过验证，总感觉第二种方法可靠点，但在生产环境，有数据时，会出现什么情况，还需检验。
----------------------------------------------------------------------------------------------------------------------------------

php artisan migrate:make create_authors_table
php artisan migrate:install create_users_table
php artisan migrate:install create_columns_table

php artisan make:migration create_columns_table --create=columns        创建一个2016_09_15_152223_create_columns_table.php的迁移文件

php artisan migrate:install     初始化迁移表，创建[migrations]表
----------------------------------------------------------------------------------------------------------------------------------
使用方法：
1、首次进行迁移操作
php artisan migrate             执行所有未执行的迁移，会自动创建表，可进数据库查看

2、添加一张表
php artisan make:migration create_columns_table --create=columns        创建一个2016_09_15_152223_create_columns_table.php的迁移文件
如果需要自定义，可自行修改，修改完成后，执行
php artisan migrate
----------------------------------------------------------------------------------------------------------------------------------
php artisan migrate:rollback    如果要放弃上一次操作，回滚上一次的迁移
