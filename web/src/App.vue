<template>
  <div id="app">
    <div class="pages">
      <router-view />
      <van-tabbar route>
        <van-tabbar-item replace to="/">首页</van-tabbar-item>
        <van-tabbar-item replace to="/front">前端</van-tabbar-item>
        <van-tabbar-item replace to="/serves">后端</van-tabbar-item>
        <van-tabbar-item replace to="/info">我的</van-tabbar-item>
      </van-tabbar>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  methods: {}
};
</script>
<style lang="scss">
.van-tabbar-item__text{
  font-size: 14px;
}
</style>
