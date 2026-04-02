/**
 * 症状卡片组件
 * 对应类图2.3节 SymptomCardComponent，实现症状卡片的渲染与交互
 */
export default {
  props: {
    symptom: {
      type: Object,
      required: true,
      default: () => ({
        sId: "",
        sName: "",
        sIcon: "",
      }),
    },
  },
  template: `
    <div 
      :id="\`symp-card-\${symptom.sId}\`" 
      class="col-md-4"
    >
      <div class="card symp-card" @click="handleClick">
        <div class="card-body text-center">
          <img :src="symptom.sIcon" :alt="symptom.sName" width="60" height="60" class="mb-3">
          <h5 class="card-title">{{ symptom.sName }}</h5>
        </div>
      </div>
    </div>
  `,
  methods: {
    // 卡片点击事件：跳转至症状详情页
    handleClick() {
      window.location.href = `symptom-detail.html?sId=${this.symptom.sId}`;
      // 触发父组件的历史记录保存事件
      this.$emit("browse", this.symptom.sId);
    },
  },
};
