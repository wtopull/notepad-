<template>
  <div class="view home">
    <van-swipe :autoplay="3000" :height="150">
      <van-swipe-item v-for="(image, index) in images" :key="index">
        <img v-lazy="$api.baseUrl +''+ image.image" />
      </van-swipe-item>
    </van-swipe>
    <van-notice-bar left-icon="volume-o" :speed="50" background="#ffffff">通知内f容通知内f容通知内f容</van-notice-bar>
    <div>
      <div class="h_list" v-for="(item,index) in artLists" :key="index" @click="toDetail(item)">
        <div class="h_list_t">
          <p class="h_list_t_title">
            <van-image
              width="26"
              height="26"
              fit="cover"
              lazy-load
              round
              src="http://img1.imgtn.bdimg.com/it/u=2088455182,192644019&fm=26&gp=0.jpg"
            />
            <span>{{item.title}}</span>
          </p>
          <p class="h_list_t_time">{{item.sort | setDate}}</p>
        </div>
        <div class="h_list_c">
          <p class="h_list_c_ass">很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,</p>
          <van-image
            width="48"
            height="48"
            fit="cover"
            lazy-load
            src="http://img1.imgtn.bdimg.com/it/u=2808968104,3449164699&fm=26&gp=0.jpg"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "home",
  data() {
    return {
      images: [],
      artLists: {}
    };
  },
  mounted() {
    this.article();
    this.getBanner();
  },
  methods: {
    article: function() {
      this.$api.post("article/article").then(res => {
        this.artLists = res.data;
      });
    },
    // 去详情页
    toDetail(item) {
      localStorage.setItem("infoID",item.id);
      this.$router.push("/detail");
    },
    // banner
    getBanner() {
      this.$api.post("ab/lists").then(res => {
        this.images = res.data;
      });
    }
  },
  filters: {
    setDate(value) {
      let date = Math.floor(new Date(value).getTime() / 1000);
      let nowDate = Math.floor(new Date().getTime() / 1000);
      let kk = nowDate - date;
      return kk < 60
        ? "刚刚"
        : kk > 60 && kk < 120
        ? "1分钟前"
        : kk > 120 && kk < 180
        ? "2分钟前"
        : kk > 180 && kk < 240
        ? "3分钟前"
        : kk > 240 && kk < 300
        ? "4分钟前"
        : kk > 300 && kk < 600
        ? "5分钟前"
        : kk > 600 && kk < 3600
        ? "10分钟前"
        : kk > 3600
        ? "一小时前"
        : "好久以前";
    }
  }
};
</script>
<style lang="scss" scoped>
.van-swipe-item {
  img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
}
@import "@/assets/css/home.scss";
</style>
