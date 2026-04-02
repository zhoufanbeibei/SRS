<?php
/**
 * 症状接口
 */
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Origin: *"); // 允许所有来源
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once '../service/SymptomService.php';

$symptomService = new SymptomService();
$action = $_GET['action'] ?? '';
$response = [
    'code' => 400,
    'msg' => '无效的操作',
    'data' => []
];

switch ($action) {
    case 'getAll':
        $data = $symptomService->getAllSymptoms();
        $response = [
            'code' => 200,
            'msg' => '获取成功',
            'data' => $data
        ];
        break;

    case 'getSubModules':
        $sId = $_GET['sId'] ?? '';
        $data = $symptomService->getSubModulesBySId($sId);
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

    case 'search':
        $keyword = $_GET['kw'] ?? '';
        if (empty($keyword)) {
            $response['msg'] = '搜索关键词不能为空';
            break;
        }
        $data = $symptomService->searchSymptoms($keyword);
        $response = [
            'code' => 200,
            'msg' => $data ? '搜索成功' : '无匹配结果',
            'data' => $data
        ];
        break;

    case 'getSubModuleName':
        $smId = $_GET['smId'] ?? '';
        $data = ['smName' => $symptomService->getSubModuleName($smId)];
        $response = [
            'code' => 200,
            'msg' => '获取成功',
            'data' => $data
        ];
        break;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>