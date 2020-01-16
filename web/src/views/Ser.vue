<template>
  <div class="serves">
    <van-nav-bar left-text="寻找最好的语言" right-text="搜索" @click-right="onClickRight" />
    <!-- <form action="/">
      <van-search
        v-model="search"
        placeholder="请输入搜索关键词"
        show-action
        @search="onSearch"
        @cancel="onCancel"
      />
    </form> -->
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <div class="s_box">
        <div>后端</div>
      </div>
    </van-pull-refresh>
  </div>
</template>

<script>
export default {
  name: "home",
  data() {
    return {
      search: "",
      isLoading: false,
      lists: []
    };
  },
  mounted() {},
  methods: {
    onClickRight() {
      console.log("搜索");
    },
    // 搜索
    onSearch() {
      console.log(1);
    },
    // 取消搜索
    onCancel() {
      console.log(2);
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
};
</script>
<style lang="scss" scoped>
.serves,
.s_box {
  height: 100%;
}
</style>