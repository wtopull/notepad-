<template>
  <div class="cpages login">
    <van-nav-bar title="用户登录" left-arrow @click-left="onClickLeft" />
    <div class="login_input login_user">
      <van-field v-model="username" label="账号" placeholder="请输入用户名" />
    </div>
    <div class="login_input login_pwd">
      <van-field v-model="password" type="password" label="密码" placeholder="请输入密码(6-16位)" />
    </div>
    <p class="set_pwd">
      <span @click="toSetPWD">忘记密码？</span>
    </p>
    <div class="login_btn login_btn_login">
      <van-button size="large" :loading="islogin" color="#ff6880" @click="login">登录</van-button>
    </div>
    <div class="login_btn">
      <van-button size="large" color="#ff6880" plain to="/register">注册</van-button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      islogin: false,
      username: "criss",
      password: "123456"
    };
  },
  mounted() {},
  methods: {
    login: function(){
      let url = "";
      // url = "http://172.17.16.243/api/user/login";
      url = "https://35666j.com/index.php/index/webs/banner"
      // this.$axios.post(url).then(res => {
      //   console.log(res);
      // })
      this.$api("user/login").then(res => {
        console.log(res);
      })

      // this.$api.post("user/login",{username: this.username,password:this.password}).then( res => {
      //   console.log(res);
      // })

      // this.islogin = true;
      // setTimeout(() => {
      //   this.islogin = false;
      //   this.$router.push("/info");
      // }, 1280);
    },
    onClickLeft() {
      // this.$toast.loading({
      //   message: "加载中...",
      //   forbidClick: true,
      //   loadingType: "spinner"
      // });
      this.$router.push("/info");
    },
    toSetPWD:function(){
      this.$router.push("/setpwd")
    }
  },
  components: {}
};
</script>
<style lang="scss" scoped>
.login_input {
  margin: 0px 30px;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #dcdcdc;
}
.login_user{
  margin-top: 130px;
}
.set_pwd{
  margin: 0;
  padding: 0px 30px;
  font-size: 14px;
  line-height: 36px;
  text-align: right;
}
.login_btn{
  padding: 0px 30px;
  margin-bottom: 15px;
}
.login_btn_login{
  margin-top: 40px;
}
</style>