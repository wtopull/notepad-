<template>
  <div class="serves">
    <van-nav-bar left-text="寻找最好的语言" />
    <!-- <van-nav-bar left-text="寻找最好的语言" right-text="搜索" @click-right="onClickRight" /> -->
    <!-- <form action="/">
      <van-search
        v-model="search"
        placeholder="请输入搜索关键词"
        show-action
        @search="onSearch"
        @cancel="onCancel"
      />
    </form>-->
    <!-- <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <div class="s_box">
        <div>后端</div>
      </div>
    </van-pull-refresh>-->
    <van-tabs animated swipeable @click="onClick" @change="change">
      <van-tab v-for="(lable,lableIndex) in lable" :title="lable" :key="lableIndex">
        <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
          <van-list v-model="loading" :finished="finished" finished-text="没有更多了">
            <van-cell
              v-for="(item,index) in infoList"
              :key="index"
              :title="item.title"
              is-link
              @click="toDetail(item)"
            />
          </van-list>
        </van-pull-refresh>
      </van-tab>
    </van-tabs>
  </div>
</template>

<script>
import { setItem, getItem } from "@/assets/js/utils";
export default {
  data() {
    return {
      search: "",
      isLoading: false,
      infoList: [],
      lable: {}
    };
  },
  mounted() {
    this.getInfos();
  },
  methods: {
    change: function(e) {
      let lableName = [];
      let lableNum = [];
      for (const i in this.lable) {
        if (this.lable.hasOwnProperty(i)) {
          lableName.push(this.lable[i]);
          lableNum.push(i);
        }
      }
      this.id = lableNum[e];
      this.getArticles();
    },
    // 去详情页
    toDetail(item) {
      let infos = {};
      infos.id = item.id;
      infos.router = "Ser";
      localStorage.setItem("infos", JSON.stringify(infos));
      this.$router.push("/detail");
    },
    onClick: function(name, title) {
      this.id = Object.keys(this.lable)[name];
      this.getArticles();
    },
    getInfos: function() {
      let lable = JSON.parse(getItem("serve_lable"));
      let infoList = JSON.parse(getItem("serve_infoList"));
      if (lable) {
        this.infoList = infoList;
        this.lable = lable;
      } else {
        this.$api.post("TabBars/cateArticleInfos", { cate_id: 8 }).then(res => {
          this.infoList = res.data.articles;
          this.lable = res.data.lable;
          setItem("serve_lable", JSON.stringify(res.data.lable));
          setItem("serve_infoList", JSON.stringify(res.data.articles));
        });
      }
    },
    getArticles: function() {
      this.loading = false;
      this.$api.post("TabBars/cateArticles", { cate_id: this.id }).then(res => {
        this.infoList = res.data;
        this.finished = true;
      });
    },
    onLoad() {
      // 异步更新数据
      setTimeout(() => {
        for (let i = 0; i < 20; i++) {
          this.infoList.push(this.infoList.length + 1);
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
        this.getInfos();
        this.isLoading = false;
      }, 1000);
    },
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