<template>
  <div class="view info">
    <div class="users">
      <van-image class="user_tximg" :src="userTximg" lazy-load />
      <div class="uesr_text">
        <router-link to="/login" tag="span">登录</router-link>
        <span class="uesr_text_tips">|</span>
        <router-link to="/register" tag="span">注册</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import lists from "@/assets/js/lists.js"
export default {
  name: "home",
  data() {
    return {
      lists,
      userTximg: require("../assets/img/icon_avatar.png")
    };
  },
  components: {}
};
</script>
<style lang="scss" scoped>
.users{
  height: 160px;
  background: url("../assets/img/info/img_banner_n.png") no-repeat center center;
  background-size: 100% 100%;
  display: flex;
  align-items: center;
  .user_tximg{
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0px 15px;
  }
  .uesr_text{
    color: #ffffff;
    font-size: 16px;
    .uesr_text_tips{
      margin: 0px 20px;
    }
  }
}
.van-cell__title {
  display: flex;
  align-items: center;
  .van-image {
    margin-right: 10px;
  }
}
</style>