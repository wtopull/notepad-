<template>
  <div class="front">
    <van-nav-bar left-text="面向大前端" />
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
import {setItem,getItem} from '@/assets/js/utils'
export default {
  data() {
    return {
      active: 0,
      isLoading: false,
      infoList: [],
      lable: {},
      loading: false,
      finished: false,
      id: 0
    };
  },
  mounted() {
    this.getInfos();
  },
  methods: {
    change: function(e){
      let lableName = [];
      let lableNum = [];
      for (const i in this.lable) {
        if (this.lable.hasOwnProperty(i)) {
          lableName.push(this.lable[i]);
          lableNum.push(i)
        }
      }
      this.id = lableNum[e];
      this.getArticles();
    },
    // 去详情页
    toDetail(item) {
      let infos = {};
      infos.id = item.id;
      infos.router = "Fro";
      localStorage.setItem("infos", JSON.stringify(infos));
      this.$router.push("/detail");
    },
    onClick: function(name, title) {
      console.log(name,title);
      this.id = Object.keys(this.lable)[name];
      this.getArticles();
    },
    getInfos: function() {
      let lable = JSON.parse(getItem("lable"));
      let infoList = JSON.parse(getItem("infoList"));
      if(lable) {
        this.infoList = infoList
        this.lable = lable
      } else {
        this.$api.post("TabBars/cateArticleInfos", { cate_id: 8 }).then(res => {
          this.infoList = res.data.articles;
          this.lable = res.data.lable;
          setItem("lable",JSON.stringify(res.data.lable));
          setItem("infoList",JSON.stringify(res.data.articles));
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
    }
  },
  components: {}
};
</script>
<style lang="scss" scoped></style>