<template>
  <div class="issue">
    <!-- <van-nav-bar left-text="文章发布" left-arrow @click-left="onClickLeft" /> -->
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <div class="issue_box">
        <vue-editor
          v-model="content"
          @imageAdded="handleImageAdded"
          :editorToolbar="customToolbar"
        />
      </div>
    </van-pull-refresh>
  </div>
</template>
<script>
import { VueEditor } from "vue2-editor";
export default {
  data() {
    return {
      isLoading: false,
      content: "<h1>npm install vue2-editor</h1>",
      customToolbar: [
        [{"header":[false,1,2,3,4]}, "bold", "italic", "underline"],
        [{ align: "" }, { align: "center" }, { align: "right" }],
        [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
        [{ background: [] }, { color: [] }],
        ["image", "link", "video", ]
      ]
    };
  },
  mounted() {},
  methods: {
    handleImageAdded: function(file, Editor, cursorLocation) {
      //上传图片操作
      //把获取到的图片url 插入到鼠标所在位置 回显图片
      // Editor.insertEmbed(cursorLocation, "image", url);
    },
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
    VueEditor
  }
};
</script>
<style lang="scss" scoped>
.issue,
.issue_box {
  height: 100%;
}
</style>