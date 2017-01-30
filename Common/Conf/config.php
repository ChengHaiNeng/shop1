<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE' => 'mysql', // 数据库类型
	'DB_HOST' => '127.0.0.1', // 服务器地址
	'DB_NAME' => 'shop', // 数据库名
	'DB_USER' => 'root', // 用户名
	'DB_PWD' => 'primary', // 密码
	'LOG_RECORD' => true, //系统日志在记录的时候需要开启debug调试模式,如果debug模式没有开启,日志并不记录.
	'DB_SLQ_LOG' => true, //SQL执行日志记录
	'cookie_salt' =>'asasd',
	'URL_CASE_INSENSITIVE' => false,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'URL_PATHINFO_DEPR'     =>  '/',	// PATHINFO模式下，各参数之间的分割符号
);