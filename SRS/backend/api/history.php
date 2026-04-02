<?php
/**
 * 历史记录接口
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
    case 'save':
        $sId = $postData['sId'] ?? '';
        $deviceId = $postData['deviceId'] ?? '';
        $browseTime = time();
        if (!is_numeric($sId) || empty($deviceId)) {
            $response['msg'] = '参数错误';
            break;
        }
        $result = $userService->saveBrowseHistory($deviceId, $sId, $browseTime);
        $response = [
            'code' => 200,
            'msg' => '记录保存成功',
            'data' => []
        ];
        break;

    case 'get':
        $deviceId = $postData['deviceId'] ?? '';
        if (empty($deviceId)) {
            $response['msg'] = '设备ID缺失';
            break;
        }
        $historyList = $userService->getBrowseHistory($deviceId);
        $response = [
            'code' => 200,
            'msg' => '获取成功',
            'data' => $historyList
        ];
        break;

    case 'clear':
        $deviceId = $postData['deviceId'] ?? '';
        if (empty($deviceId)) {
            $response['msg'] = '设备ID缺失';
            break;
        }
        $result = $userService->clearBrowseHistory($deviceId);
        $response = [
            'code' => 200,
            'msg' => '清空成功',
            'data' => []
        ];
        break;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>