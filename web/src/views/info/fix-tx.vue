<template>
  <div class="cpages tx">
    <van-nav-bar left-arrow left-text="返回" title="设置头像" @click-left="onClickLeft" />
    <div class="tx_box">
      <van-uploader v-model="fileList" multiple :max-count="1" :before-read="beforeRead" />
      <van-button class="upload" type="primary" color="#ff6880" block>立即上传</van-button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      fileList: []
    };
  },
  mounted() {},
  methods: {
    onClickLeft() {
      this.$router.push("/Info");
    },
    // 校验
    beforeRead(file) {
      if (file.size > 5242880) {
        this.$toast({
          message: "图片大于5M",
          forbidClick: true
        });
        return false;
      } else if (file.type === "image/jpeg") {
        return true;
      } else if (file.type === "image/jpg") {
        return true;
      } else if (file.type === "image/png") {
        return true;
      } else {
        this.$toast({
          message: "只支持jpeg,jpg,png格式的图片",
          forbidClick: true
        });
        return false;
      }
    }
  },
  components: {}
};
</script>
<style lang="scss" scoped>
.tx {
  background: #f2f2f2;
}
.tx_box {
  padding: 10px;
}
.upload {
  width: 80%;
  margin: 120px auto 0;
}
</style>