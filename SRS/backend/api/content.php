<?php
/**
 * 内容接口
 */
header("Access-Control-Allow-Origin: *"); // 允许所有来源
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

require_once '../service/ContentService.php';

$contentService = new ContentService();
$postData = json_decode(file_get_contents('php://input'), true) ?? $_GET;
$action = $postData['action'] ?? '';
$response = [
    'code' => 400,
    'msg' => '无效的操作',
    'data' => []
];

switch ($action) {
    case 'getContent':
        $sId = $postData['sId'] ?? '';
        $smId = $postData['smId'] ?? '';
        $mId = $postData['mId'] ?? 1;
        $data = $contentService->getContentBySsmM($sId, $smId, $mId);
        if (isset($data['error'])) {
            $response['msg'] = $data['error'];
        } else {
            $response = [
                'code' => 200,
                'msg' => '获取成功',
                'data' => $data
            ];
        }
        break;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>