/**
 * 显示错误提示（对应ID:error-alert）
 * @param {string} msg - 错误信息
 * @param {string} code - 错误码（E001/E002）
 */

// utils.js里的showError函数修改
function showError(msg, code) {
  const errorAlert = document.getElementById("error-alert");
  if (!errorAlert) {
    // 元素不存在时直接打印控制台
    console.error(`错误${code}：${msg}`);
    return;
  }
  errorAlert.innerHTML = `<strong>错误 ${code}：</strong>${msg}`;
  errorAlert.style.display = "block";
  setTimeout(() => {
    errorAlert.style.display = "none";
  }, 3000);
}
/**
 * 绑定全局快捷键（对应SRS 3.1节K1-K4）
 */
function bindShortcuts() {
  document.addEventListener("keydown", (e) => {
    // K2: Ctrl+F 激活搜索框
    if (e.ctrlKey && e.key === "f") {
      e.preventDefault();
      const searchInput = document.querySelector(".input-group input");
      searchInput.focus();
      searchInput.select();
    }
    // K3: Alt+1 切换简略版
    if (e.altKey && e.key === "1") {
      e.preventDefault();
      window.localStorage.setItem("currentMode", 1);
      location.reload();
    }
    // K4: Alt+2 切换详细版
    if (e.altKey && e.key === "2") {
      e.preventDefault();
      window.localStorage.setItem("currentMode", 2);
      location.reload();
    }
  });
}

/**
 * 获取设备唯一标识（用于游客身份识别）
 * @returns {string} 设备ID
 */
function getDeviceId() {
  let deviceId = window.localStorage.getItem("deviceId");
  if (!deviceId) {
    // 生成随机设备ID
    deviceId = "dev_" + Math.random().toString(36).substr(2, 10);
    window.localStorage.setItem("deviceId", deviceId);
  }
  return deviceId;
}

/**
 * 获取当前用户偏好模式（默认简略版）
 * @returns {number} 模式ID 1=简略版 2=详细版
 */
function getCurrentMode() {
  return parseInt(window.localStorage.getItem("currentMode")) || 1;
}
