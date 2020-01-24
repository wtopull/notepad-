<template>
  <div class="cpages tx">
    <van-nav-bar left-arrow left-text="返回" title="设置头像" @click-left="onClickLeft" />
    <div class="tx_box">
      <!-- <van-uploader v-model="fileList" :max-count="1" :before-read="beforeRead" /> -->
      <input type="file" accept="image/*" @change="headImgChange" />
      <!-- <van-button class="upload" type="primary" color="#ff6880" block @click="update">立即上传</van-button> -->
    </div>
  </div>
</template>
<script>
import Cookies from "js-cookie";
import axios from 'axios'
export default {
  data() {
    return {
      fileList: [],
      file: {}
    };
  },
  mounted() {},
  methods: {
    headImgChange(e) {
      const token = Cookies.get( 'token' )
      let instance = axios.create();
      let file = e.target.files[0];
      const formData = new FormData();
      formData.append("file", file);
      formData.append("token", token);
      axios.defaults.headers.post["Content-Type"] = "multipart/form-data";
      instance.post("http://172.17.16.243/api/user/upload", formData).then(res => {
        console.log(res.data);
      });
    },
    update: function() {
      let formData = new FormData();
      formData.append("file", this.file);
      console.log(formData);
    },
    // 返回
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
      } else if (
        file.type === "image/jpeg" ||
        file.type === "image/jpg" ||
        file.type === "image/png"
      ) {
        console.log(file);
        this.file = file;
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