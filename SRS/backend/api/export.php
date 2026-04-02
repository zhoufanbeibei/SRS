<?php
/**
 * 内容导出接口
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: *"); // 允许所有来源
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once '../service/ContentService.php';

$contentService = new ContentService();
$postData = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $postData['action'] ?? '';
$response = [
    'code' => 400,
    'msg' => '无效的操作',
    'data' => []
];

if ($action === 'export') {
    $sId = $postData['sId'] ?? '';
    $smId = $postData['smId'] ?? '';
    $mId = $postData['mId'] ?? 1;
    $format = $postData['format'] ?? 'txt';

    if (!is_numeric($sId) || !is_numeric($smId)) {
        $response['msg'] = '参数错误';
        echo json_encode($response);
        exit;
    }

    $contentData = $contentService->getContentBySsmM($sId, $smId, $mId);
    if (isset($contentData['error'])) {
        $response['msg'] = $contentData['error'];
        echo json_encode($response);
        exit;
    }

    switch ($format) {
        case 'txt':
            header('Content-Type: text/plain; charset=utf-8');
            header('Content-Disposition: attachment; filename="content.txt"');
            echo $contentData['contentText'];
            break;
        
        default:
            $response['msg'] = '不支持的导出格式';
            echo json_encode($response);
    }
} else {
    echo json_encode($response);
}
?>