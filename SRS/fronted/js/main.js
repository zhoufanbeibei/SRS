/**
 * Vue入口文件
 * 对应类图2.3节前端组件类的统一注册与初始化
 */
import { createApp } from "vue";
import SymptomCard from "./components/SymptomCard.js";
import SubModuleCard from "./components/SubModuleCard.js";
import ContentRenderer from "./components/ContentRenderer.js";

// 创建Vue应用实例
const app = createApp({
  data() {
    return {
      globalLoading: false, // 全局加载状态
      currentUser: null, // 当前用户（游客标识）
    };
  },
  methods: {
    // 全局加载状态控制
    setGlobalLoading(status) {
      this.globalLoading = status;
    },
    // 获取当前设备ID（全局方法）
    getDeviceId() {
      let deviceId = localStorage.getItem("deviceId");
      if (!deviceId) {
        deviceId = "dev_" + Math.random().toString(36).substr(2, 10);
        localStorage.setItem("deviceId", deviceId);
      }
      return deviceId;
    },
  },
});

// 注册全局组件
app.component("SymptomCard", SymptomCard);
app.component("SubModuleCard", SubModuleCard);
app.component("ContentRenderer", ContentRenderer);

// 挂载到全局DOM节点（若使用单页应用模式）
// app.mount('#app');

// 导出应用实例供其他页面使用
export default app;
