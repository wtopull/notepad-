<template>
  <div id="app" ref="app">
    <div class="pages">
      <router-view />
      <van-tabbar route>
        <van-tabbar-item replace to="/Home">{{$t("Home")}}</van-tabbar-item>
        <van-tabbar-item replace to="/Fro">{{$t("Fro")}}</van-tabbar-item>
        <van-tabbar-item replace to="/Ser">{{$t("Ser")}}</van-tabbar-item>
        <van-tabbar-item replace to="/Info">{{$t("Info")}}</van-tabbar-item>
      </van-tabbar>
    </div>
  </div>
</template>
<script>
import Vue from "vue";
import { mapGetters } from "vuex";
export default {
  data() {
    return {};
  },
  computed: {
    ...mapGetters(["getTheme"])
  },
  watch: {
    getTheme: function(val) {
      this.switchTheme(val);
    }
  },
  mounted() {
    this.switchTheme(this.$store.state.theme);
  },
  methods: {
    switchTheme: function(themeName) {
      this.$refs.app.className = themeName + "_theme";
      document.body.className = themeName + "_theme";
      Vue.prototype.$theme = themeName;
    }
  }
};
</script>
<style lang="scss">
.van-tabbar-item__text {
  font-size: 14px;
}
</style>
