<template>
  <div class="view info">
    <div class="users">
      <van-image class="user_tximg" :src="userTximg" lazy-load />
      <div class="uesr_text">
        <router-link to="/login" tag="span">{{$t('user.Login')}}</router-link>
        <span class="uesr_text_tips">|</span>
        <router-link to="/register" tag="span">{{$t('user.Register')}}</router-link>
      </div>
    </div>
    <van-cell center :title="$t('Theme')">
      <van-switch v-model="checked" slot="right-icon" size="24" />
    </van-cell>
    <van-cell center :title="$t('Language')">
      <van-switch v-model="lang" slot="right-icon" size="24" @change="switchLang" />
    </van-cell>
  </div>
</template>

<script>
import Cookies from 'js-cookie'
export default {
  name: "home",
  data() {
    return {
      userTximg: require("../assets/img/icon_avatar.png"),
      checked: false,
      lang: false
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
    if (Cookies.get('language') == "zh") {
      this.lang = false;
    } else {
      this.lang = true;
    }
  },
  methods:{
    switchLang(e){
      if (e) {
        this.$store.dispatch("setLanguage", "en");
        this.$i18n.locale = "en"
      } else {
        this.$store.dispatch("setLanguage", "zh");
        this.$i18n.locale = "zh"
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