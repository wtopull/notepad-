<template>
  <div class="view info">
    <!-- <div class="users" v-if="userInfo.username == ''">
      <van-image class="user_tximg" :src="userTximg" lazy-load @click="toFixTX" />
      <div class="uesr_text">
        <router-link to="/" tag="span">{{$t('user.Login')}}</router-link>
        <span class="uesr_text_tips">|</span>
        <router-link to="/register" tag="span">{{$t('user.Register')}}</router-link>
      </div>
    </div>-->
    <div class="users">
      <van-image class="user_tximg" :src="userTximg" lazy-load @click="toFixTX" />
      <div class="uesr_text">
        <span>{{userInfo.username}}</span>
      </div>
    </div>
    <van-cell center :title="$t('Theme')">
      <van-switch v-model="theme" slot="right-icon" size="24" @change="switchTheme" />
    </van-cell>
    <van-cell center :title="$t('Language')">
      <van-switch v-model="lang" slot="right-icon" size="24" @change="switchLang" />
    </van-cell>
    <van-cell :title="$t('NightMode')" is-link />
    <van-cell :title="$t('Issue')" is-link to="/issue" v-if="userInfo.isrelease === '1'" />
    <div style="margin:100px auto 0;width:80%;">
      <van-button
        block
        color="linear-gradient(to right, #4bb0ff, #1B89FF)"
        @click="logout"
      >{{$t('user.LoginOut')}}</van-button>
    </div>
  </div>
</template>

<script>
import Cookies from "js-cookie";
export default {
  data() {
    return {
      userTximg: require("../assets/img/icon_avatar.png"),
      lang: false,
      theme: false,
      userInfo: {}
    };
  },
  watch: {
    theme: function(val) {
      if (val) {
        this.$store.dispatch("setTheme", "black");
      } else {
        this.$store.dispatch("setTheme", "default");
      }
    }
  },
  mounted() {
    if (this.$store.state.theme == "default") {
      this.theme = false;
    } else {
      this.theme = true;
    }
    let user = JSON.parse(Cookies.get("user"));
    this.userInfo = user;
    if (user.image) {
      this.userTximg = user.image;
    }
    if (user.language === 1) {
      this.lang = false;
    } else {
      this.lang = true;
    }
  },
  methods: {
    // 设置头像
    toFixTX() {
      this.$router.push("/fixTx");
    },
    // 主题
    switchTheme(e) {
      let num = 0;
      if (e) {
        num = 0;
      } else {
        num = 1;
      }
      this.$api.post("user/editInfo", { theme: num }).then(res => {
        this.$toast(res.msg);
      });
    },
    // 语言
    switchLang(e) {
      let num = 0;
      if (e) {
        this.$store.dispatch("setLanguage", "en");
        this.$i18n.locale = "en";
        num = 0;
      } else {
        this.$store.dispatch("setLanguage", "zh");
        this.$i18n.locale = "zh";
        num = 1;
      }
      this.$api.post("user/editInfo", { language: num }).then(res => {
        this.$toast(res.msg);
        let user = JSON.parse(Cookies.get("user"));
        if (e) {
          user.language = 0;
          Cookies.set("language", "en");
          Cookies.set("user", JSON.stringify(user));
          this.$i18n.locale = "en";
        } else {
          user.language = 1;
          Cookies.set("language", "zh");
          Cookies.set("user", JSON.stringify(user));
          this.$i18n.locale = "zh";
        }
      });
    },
    logout: function() {
      Cookies.remove("language");
      Cookies.remove("theme");
      Cookies.remove("token");
      Cookies.remove("user");
      this.$router.push("/");
    }
  },
  components: {}
};
</script>
<style lang="scss" scoped>
.users {
  height: 160px;
  background: url("../assets/img/info/img_banner_n.png") no-repeat center center;
  background-size: 100% 100%;
  display: flex;
  align-items: center;
  .user_tximg {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0px 15px;
  }
  .uesr_text {
    color: #ffffff;
    font-size: 16px;
    .uesr_text_tips {
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