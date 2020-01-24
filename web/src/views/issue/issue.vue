<template>
  <div class="issue">
    <van-nav-bar left-text="文章发布" left-arrow @click-left="onClickLeft" />
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <div class="issue_box">
        <div>发布页面</div>
      </div>
    </van-pull-refresh>
  </div>
</template>
<script>
export default {
  data () {
    return {
      isLoading: false,
    }
  },
  mounted() {},
  methods: {
    onClickLeft() {
      this.$router.push("/Info");
    },
    // 下拉刷新
    onRefresh() {
      setTimeout(() => {
        this.$toast("刷新成功");
        this.isLoading = false;
      }, 1000);
    }
  },
  components: {}
}
</script>
<style lang="scss" scoped>
.issue,.issue_box {
  height: 100%;
}
</style>