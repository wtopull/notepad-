<template>
  <div class="issue">
    <van-nav-bar
      left-text="文章发布"
      right-text="发布"
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />
    <div class="issue_box" id="issue_box">
      <div class="md">
        <vue-markdown v-highlight :source="md"></vue-markdown>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import VueMarkdown from "vue-markdown";
import hljs from 'highlight.js'
import 'highlight.js/styles/arta.css'
export default {
  data() {
    return {
      md: "",
      codeStyle: "arta",
      isLoading: false,
      content: ""
    };
  },
  mounted() {
    this.getMD();
  },
  methods: {
    getMD: function() {
      this.$toast.loading({
        message: "加载中...",
        forbidClick: true
      });
      let wid = "20200205"
      axios.get(`http://172.17.16.38:8888/details?wid=${wid}`)
        .then(res => {
          if(res.data.status === 200){
            this.md = res.data.data;
            this.$nextTick(()=>{
              let blocks = document.getElementById("issue_box").querySelectorAll("pre code");
              blocks.forEach(block => {
                hljs.highlightBlock(block);
              });
            })
            setTimeout(() => {
              this.$toast.clear();
            }, 250);
          }
        });
    },
    // 发布
    onClickRight: function() {},
    // 返回
    onClickLeft() {
      this.$router.push("/Info");
    },
    // 下拉刷新
    onRefresh() {
      setTimeout(() => {
        this.$toast("刷新成功");
        this.isLoading = false;
      }, 1000);
    }
  },
  components: {
    VueMarkdown
  }
};
</script>
<style lang="scss" scoped>
.issue {
  height: 100%;
}
.issue_box {
  width: 100%;
  height: calc(100% - 95px);
  overflow: hidden;
  overflow-y: auto;
}
.quillWrapper {
  background: #fff;
}
</style>