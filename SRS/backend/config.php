<?php
// 数据库配置（PHPStudy默认参数）
$config = [
    'host' => 'medical.data',    // MySQL地址，固定localhost
    'port' => 3306,           // 默认端口，如果更改端口这里需要同步修改
    'user' => 'bei',         // MySQL默认用户名
    'password' => '123456',     // 你的MySQL密码（没改就是root）
    'database' => 'medical_data', // 刚创建的数据库名
    'charset' => 'utf8mb4'
];

// 创建数据库连接
$conn = mysqli_connect(
    $config['host'],
    $config['user'],
    $config['password'],
    $config['database'],
    $config['port']
);

// 检查连接是否成功（失败则提示错误）
if (!$conn) {
    die(json_encode([
        'code' => 500,
        'msg' => '数据库连接失败：' . mysqli_connect_error(),
        'data' => []
    ]));
}

// 设置字符集，避免中文乱码
mysqli_set_charset($conn, $config['charset']);

// 跨域请求头（必须保留，否则前端请求会被拦截）
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");
?>