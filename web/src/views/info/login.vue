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
import Cookies from "js-cookie";
export default {
  data() {
    return {
      islogin: false,
      username: "",
      password: ""
    };
  },
  mounted() {
    if (
      location.hostname === "172.17.16.38" ||
      location.hostname === "localhost"
    ) {
      this.username = "criss168";
      this.password = "11211121";
    }
  },
  methods: {
    // 登录
    login: function() {
      this.islogin = true;
      this.$api
        .post("user/login", {
          username: this.username,
          password: this.password
        })
        .then(res => {
          if (res.code === 1000) {
            Cookies.set("token", res.data.token);
            Cookies.set("user", JSON.stringify(res.data));
            // 设置主题色
            if (res.data.theme) {
              this.$store.dispatch("setTheme", "default");
            } else {
              this.$store.dispatch("setTheme", "black");
            }
            if (res.data.language === 1) {
              this.$store.dispatch("setLanguage", "zh");
              this.$i18n.locale = "zh";
            } else {
              this.$store.dispatch("setLanguage", "en");
              this.$i18n.locale = "en";
            }
            // 设置语言
            this.islogin = false;
            this.$toast(res.msg);
            setTimeout(() => {
              this.$router.push("/info");
            }, 1680);
          } else {
            this.$toast(res.msg);
          }
        })
        .catch(err => {
          this.islogin = false;
        });
    },
    // 返回
    onClickLeft() {
      this.$router.push("/info");
    },
    // 找回密码
    toSetPWD: function() {
      this.$router.push("/setpwd");
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
.login_user {
  margin-top: 130px;
}
.set_pwd {
  margin: 0;
  padding: 0px 30px;
  font-size: 14px;
  line-height: 36px;
  text-align: right;
}
.login_btn {
  padding: 0px 30px;
  margin-bottom: 15px;
}
.login_btn_login {
  margin-top: 40px;
}
</style>