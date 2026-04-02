<?php
/**
 * 模式切换接口
 */
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: *"); // 允许所有来源
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once '../service/UserService.php';

$userService = new UserService();
$postData = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $postData['action'] ?? '';
$response = [
    'code' => 400,
    'msg' => '无效的操作',
    'data' => []
];

switch ($action) {
    case 'switch':
        $mId = $postData['mId'] ?? '';
        $deviceId = $postData['deviceId'] ?? '';
        if (!in_array($mId, ['1', '2']) || empty($deviceId)) {
            $response['msg'] = '参数错误';
            break;
        }
        $result = $userService->saveModePref($deviceId, $mId);
        $response = [
            'code' => 200,
            'msg' => '模式切换记录成功',
            'data' => []
        ];
        break;

    case 'getPref':
        $deviceId = $postData['deviceId'] ?? '';
        if (empty($deviceId)) {
            $response['msg'] = '设备ID缺失';
            break;
        }
        $prefMode = $userService->getModePref($deviceId);
        $response = [
            'code' => 200,
            'msg' => '获取成功',
            'data' => ['prefMode' => $prefMode]
        ];
        break;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>