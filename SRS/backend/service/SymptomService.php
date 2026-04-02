<?php
require_once '../config.php'; // 引入数据库连接

class SymptomService {
    private $conn;

    public function __construct() {
        global $conn; // 使用全局的数据库连接
        $this->conn = $conn;
    }

    // 获取所有症状
    public function getAllSymptoms() {
    $sql = "SELECT * FROM be_symptom";
    $result = mysqli_query($this->conn, $sql);
    
    // 新增：打印SQL错误（调试用）
    if (!$result) {
        die("SQL查询失败：" . mysqli_error($this->conn));
    }
    
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

    // 根据症状ID获取小板块
    public function getSubModulesBySId($sId) {
        if (!is_numeric($sId)) return ['error' => '无效的症状ID'];
        
        // 查询小板块
        $sql = "SELECT * FROM be_submodule WHERE sId = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $sId);
        mysqli_stmt_execute($stmt);
        $subModules = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

        // 查询症状名称
        $sqlName = "SELECT sName FROM be_symptom WHERE sId = ?";
        $stmtName = mysqli_prepare($this->conn, $sqlName);
        mysqli_stmt_bind_param($stmtName, 'i', $sId);
        mysqli_stmt_execute($stmtName);
        $symptomName = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtName))['sName'] ?? '';

        return [
            'symptomName' => $symptomName,
            'subModules' => $subModules
        ];
    }

    // 搜索症状
    public function searchSymptoms($keyword) {
        $sql = "SELECT * FROM be_symptom WHERE sName LIKE ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        $likeKeyword = "%{$keyword}%";
        mysqli_stmt_bind_param($stmt, 's', $likeKeyword);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    }
}
?>