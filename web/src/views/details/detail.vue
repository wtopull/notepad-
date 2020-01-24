<template>
  <div class="cpages detail">
    <van-nav-bar :left-text="leftText" left-arrow @click-left="onClickLeft" />
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <div class="detail_box">
        <h4 class="det_title">{{lists.title}}</h4>
        <div class="det_ass">
          <span class="det_ass_author">{{lists.author}}</span>
          <span class="det_ass_time">今天</span>
        </div>
        <div class="det_con" v-html="lists.content"></div>
      </div>
    </van-pull-refresh>
  </div>
</template>
<script>
export default {
  data() {
    return {
      leftText: "",
      author: "中文社区",
      isLoading: false,
      lists: {},
      infos: {}
    };
  },
  mounted() {
    window.addEventListener("scroll", this.scrollToTop, true);
    this.infos = JSON.parse(localStorage.getItem("infos"));
    this.info();
  },
  methods: {
    info: function() {
      this.$api.post("article/info", { id: this.infos.id }).then(res => {
        this.lists = res.data;
        this.author = res.data.author;
      });
    },
    scrollToTop(e) {
      if (e.target.scrollTop > 0) {
        this.leftText = this.author;
      } else {
        this.leftText = "";
      }
    },
    onClickLeft() {
      this.$router.push(this.infos.router);
    },
    // 下拉刷新
    onRefresh() {
      setTimeout(() => {
        this.isLoading = false;
      }, 1000);
    }
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.scrollToTop, true);
  },
  components: {}
};
</script>
<style lang="scss" scoped>
.detail_box {
  padding: 15px;
}
.det_title {
  font-size: 22px;
  line-height: 1.4;
  margin-bottom: 14px;
  font-weight: 400;
}
.det_ass {
  font-size: 15px;
  margin-bottom: 20px;
}
.det_ass_author {
  color: #576b95;
  margin-right: 10px;
}
.det_ass_time {
  color: rgba(0, 0, 0, 0.3);
}
.det_con {
  overflow: hidden;
  color: #333;
  font-size: 15px;
  word-wrap: break-word;
  text-align: justify;
}
.van-pull-refresh {
  height: calc(100% - 46px);
  overflow: hidden;
  overflow-y: auto;
}
</style>