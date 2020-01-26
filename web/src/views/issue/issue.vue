<template>
  <div class="issue">
    <van-nav-bar
      left-text="文章发布"
      right-text="发布"
      left-arrow
      @click-left="onClickLeft"
      @click-right="onClickRight"
    />
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <div class="issue_box">
        <van-field v-model="text" label="标题" />
        <van-field v-model="text" label="副标题" />
        <van-field v-model="text" label="标题" />
        <van-uploader v-model="fileList1" :max-count="1" :after-read="afterRead" />
        <van-uploader v-model="fileList2" :max-count="1" :after-read="afterRead" />
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
      fileList1: [],
      fileList2: [],
      fileList3: [],
      text: "",
      isLoading: false,
      content: "<h1>npm install vue2-editor</h1>",
      customToolbar: [
        [{ header: [false, 1, 2, 3, 4] }, "bold", "italic", "underline"],
        [{ align: "" }, { align: "center" }, { align: "right" }],
        [{ list: "ordered" }, { list: "bullet" }, { list: "check" }],
        [{ background: [] }, { color: [] }],
        ["image", "link", "video"]
      ]
    };
  },
  mounted() {},
  methods: {
    // 发布
    onClickRight: function() {},
    //上传图片操作
    handleImageAdded: function(file, Editor, cursorLocation) {
      //把获取到的图片url 插入到鼠标所在位置 回显图片
      // Editor.insertEmbed(cursorLocation, "image", url);
    },
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
    VueEditor
  }
};
</script>
<style lang="scss" scoped>
.issue,
.issue_box {
  height: 100%;
}
.issue_box {
  padding: 10px;
}
.quillWrapper {
  background: #fff;
}
</style>