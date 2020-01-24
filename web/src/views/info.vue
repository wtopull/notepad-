<template>
  <div class="view info">
    <div class="users" v-if="userInfo.username == ''">
      <van-image class="user_tximg" :src="userTximg" lazy-load @click="toFixTX" />
      <div class="uesr_text">
        <router-link to="/" tag="span">{{$t('user.Login')}}</router-link>
        <span class="uesr_text_tips">|</span>
        <router-link to="/register" tag="span">{{$t('user.Register')}}</router-link>
      </div>
    </div>
    <div class="users" v-else>
      <van-image class="user_tximg" :src="userTximg" lazy-load @click="toFixTX" />
      <div class="uesr_text">
        <span>{{userInfo.username}}</span>
      </div>
    </div>
    <van-cell center :title="$t('Theme')">
      <van-switch v-model="checked" slot="right-icon" size="24" />
    </van-cell>
    <van-cell center :title="$t('Language')">
      <van-switch v-model="lang" slot="right-icon" size="24" @change="switchLang" />
    </van-cell>
    <van-cell title="夜间模式" is-link />
    <van-cell title="发布文章" is-link to="/issue"  v-if="userInfo.isrelease === '1'" />
    <div style="margin:100px auto 0;width:80%;">
      <van-button block color="linear-gradient(to right, #4bb0ff, #1B89FF)">退出登录</van-button>
    </div>
  </div>
</template>

<script>
import Cookies from "js-cookie";
export default {
  name: "home",
  data() {
    return {
      userTximg: require("../assets/img/icon_avatar.png"),
      checked: false,
      lang: false,
      userInfo: {}
    };
  },
  watch: {
    checked: function(val) {
      if (val) {
        this.$store.dispatch("setTheme", "black");
      } else {
        this.$store.commit("setTheme", "default");
      }
    }
  },
  mounted() {
    if (this.$theme == "default") {
      this.checked = false;
    } else {
      this.checked = true;
    }
    let user = JSON.parse(Cookies.get("user"));
    console.log(user);
    this.userInfo = user
    if (user.language === 1) {
      this.lang = false;
      } else {
      this.lang = true;
    }
  },
  methods: {
    toFixTX() {
      this.$router.push("/fixTx");
    },
    switchLang(e) {
      if (e) {
        this.$store.dispatch("setLanguage", "zh");
        this.$i18n.locale = "zh";
      } else {
        this.$store.dispatch("setLanguage", "en");
        this.$i18n.locale = "en";
      }
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