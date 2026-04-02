<?php
require_once '../config.php';

class UserService {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    // 保存浏览记录
    public function saveBrowseHistory($deviceId, $sId, $browseTime) {
        // 获取症状名称
        $sqlName = "SELECT sName FROM be_symptom WHERE sId = ?";
        $stmtName = mysqli_prepare($this->conn, $sqlName);
        mysqli_stmt_bind_param($stmtName, 'i', $sId);
        mysqli_stmt_execute($stmtName);
        $sName = mysqli_fetch_assoc(mysqli_stmt_get_result($stmtName))['sName'] ?? '未知症状';

        // 插入记录
        $sql = "INSERT INTO be_history (deviceId, sId, sName, browseTime) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sisi', $deviceId, $sId, $sName, $browseTime);
        return mysqli_stmt_execute($stmt);
    }

    // 获取浏览记录
    public function getBrowseHistory($deviceId) {
        $sql = "SELECT * FROM be_history WHERE deviceId = ? ORDER BY browseTime DESC";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $deviceId);
        mysqli_stmt_execute($stmt);
        return mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
    }

    // 保存模式偏好
    public function saveModePref($deviceId, $mId) {
        // 先删除旧记录
        $sqlDel = "DELETE FROM be_mode_pref WHERE deviceId = ?";
        $stmtDel = mysqli_prepare($this->conn, $sqlDel);
        mysqli_stmt_bind_param($stmtDel, 's', $deviceId);
        mysqli_stmt_execute($stmtDel);

        // 插入新记录
        $updateTime = time();
        $sqlIns = "INSERT INTO be_mode_pref (deviceId, mId, updateTime) VALUES (?, ?, ?)";
        $stmtIns = mysqli_prepare($this->conn, $sqlIns);
        mysqli_stmt_bind_param($stmtIns, 'sii', $deviceId, $mId, $updateTime);
        return mysqli_stmt_execute($stmtIns);
    }

    // 获取模式偏好
    public function getModePref($deviceId) {
        $sql = "SELECT mId FROM be_mode_pref WHERE deviceId = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $deviceId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        return $result['mId'] ?? 1; // 默认返回简略版
    }
    // 删除历史
public function clearBrowseHistory($deviceId) {
    $sql = "DELETE FROM be_history WHERE deviceId = ?";
    $stmt = mysqli_prepare($this->conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $deviceId);
    return mysqli_stmt_execute($stmt);
}
}
?>