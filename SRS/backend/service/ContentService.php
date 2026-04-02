<?php
require_once '../config.php';

class ContentService {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // 根据症状ID、小板块ID、模式ID获取内容
    public function getContentBySsmM($sId, $smId, $mId) {
        $sql = "SELECT * FROM be_content WHERE sId = ? AND smId = ? AND mId = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'iii', $sId, $smId, $mId);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt)) ?: ['error' => '无内容'];
    }
}
?>