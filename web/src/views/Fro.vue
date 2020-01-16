<template>
  <div class="front">
    <van-nav-bar left-text="面向大前端" right-text="搜索" @click-right="onClickRight" />
    <van-tabs animated swipeable>
      <van-tab v-for="index in 8" :title="'标签 ' + index" :key="index">
        <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
          <van-list v-model="loading" :finished="finished" finished-text="没有更多了" @load="onLoad">
            <van-cell v-for="item in list" :key="item" :title="item" is-link />
          </van-list>
        </van-pull-refresh>
      </van-tab>
    </van-tabs>
  </div>
</template>

<script>
export default {
  data() {
    return {
      active: 0,
      isLoading: false,
      list: [],
      loading: false,
      finished: false
    };
  },
  mounted() {},
  methods: {
    onClickRight() {
      console.log("搜索");
    },
    onLoad() {
      // 异步更新数据
      setTimeout(() => {
        for (let i = 0; i < 20; i++) {
          this.list.push(this.list.length + 1);
        }
        // 加载状态结束
        this.loading = false;
        // 数据全部加载完成
        if (this.list.length >= 80) {
          this.finished = true;
        }
      }, 1200);
    },
    // 下拉刷新
    onRefresh() {
      setTimeout(() => {
        // this.$toast("刷新成功");
        this.isLoading = false;
      }, 1000);
    }
  },
  components: {}
};
</script>
<style lang="scss" scoped></style>