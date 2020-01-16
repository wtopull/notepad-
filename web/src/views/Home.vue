<template>
  <div class="view home">
    <van-swipe :autoplay="3000" :height="150">
      <van-swipe-item v-for="(image, index) in images" :key="index">
        <img v-lazy="image.img" />
      </van-swipe-item>
    </van-swipe>
    <van-notice-bar left-icon="volume-o" :speed="50" background="#ffffff">通知内f容通知内f容通知内f容</van-notice-bar>
    <div class="h_list">
      <div class="h_list_t">
        <p class="h_list_t_title">
          <van-image width="26" height="26" fit="cover" lazy-load round src="http://img1.imgtn.bdimg.com/it/u=2088455182,192644019&fm=26&gp=0.jpg" />
          <span>HTML</span>
        </p>
        <p class="h_list_t_time">刚刚</p>
      </div>
      <div class="h_list_c">
        <p class="h_list_c_ass">很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,</p>
        <van-image width="48" height="48" fit="cover" lazy-load src="http://img1.imgtn.bdimg.com/it/u=2808968104,3449164699&fm=26&gp=0.jpg" />
      </div>
    </div>
    <div class="h_list">
      <div class="h_list_t">
        <p class="h_list_t_title">
          <van-image width="26" height="26" fit="cover" lazy-load round src="http://5b0988e595225.cdn.sohucs.com/images/20180427/a7edbf22edbf4756ac126ee282b1086f.jpeg" />
          <span>Pyhon</span>
        </p>
        <p class="h_list_t_time">1小时前</p>
      </div>
      <div class="h_list_c">
        <p class="h_list_c_ass">很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,</p>
        <van-image width="48" height="48" fit="cover" lazy-load src="http://img4.imgtn.bdimg.com/it/u=2895274932,1289346088&fm=26&gp=0.jpg" />
      </div>
    </div>
    <div class="h_list">
      <div class="h_list_t">
        <p class="h_list_t_title">
          <van-image width="26" height="26" fit="cover" lazy-load round src="http://test.rexhang.com/blog/wp-content/uploads/2016/03/20150301021016689.png" />
          <span>JS</span>
        </p>
        <p class="h_list_t_time">3小时前</p>
      </div>
      <div class="h_list_c">
        <p class="h_list_c_ass">很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,</p>
        <van-image width="48" height="48" fit="cover" lazy-load src="http://img2.imgtn.bdimg.com/it/u=3919916074,3193097114&fm=26&gp=0.jpg" />
      </div>
    </div>
    <div class="h_list">
      <div class="h_list_t">
        <p class="h_list_t_title">
          <van-image width="26" height="26" fit="cover" lazy-load round src="http://qd.php.tedu.cn/upload/20171017/20171017160204_136.jpg" />
          <span>PHP</span>
        </p>
        <p class="h_list_t_time">1小时前</p>
      </div>
      <div class="h_list_c">
        <p class="h_list_c_ass">很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,</p>
        <van-image width="48" height="48" fit="cover" lazy-load src="http://img3.houxue.com/filestore/img/2018/03/24/l/4454.jpg" />
      </div>
    </div>
    <div class="h_list">
      <div class="h_list_t">
        <p class="h_list_t_title">
          <van-image width="26" height="26" fit="cover" lazy-load round src="http://5b0988e595225.cdn.sohucs.com/images/20180427/a7edbf22edbf4756ac126ee282b1086f.jpeg" />
          <span>Pyhon</span>
        </p>
        <p class="h_list_t_time">今天</p>
      </div>
      <div class="h_list_c">
        <p class="h_list_c_ass">很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,</p>
        <van-image width="48" height="48" fit="cover" lazy-load src="http://img4.imgtn.bdimg.com/it/u=2895274932,1289346088&fm=26&gp=0.jpg" />
      </div>
    </div>
    <div class="h_list">
      <div class="h_list_t">
        <p class="h_list_t_title">
          <van-image width="26" height="26" fit="cover" lazy-load round src="http://test.rexhang.com/blog/wp-content/uploads/2016/03/20150301021016689.png" />
          <span>JS</span>
        </p>
        <p class="h_list_t_time">2020-01-15</p>
      </div>
      <div class="h_list_c">
        <p class="h_list_c_ass">很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,很多内容,</p>
        <van-image width="48" height="48" fit="cover" lazy-load src="http://img2.imgtn.bdimg.com/it/u=3919916074,3193097114&fm=26&gp=0.jpg" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "home",
  data() {
    return {
      images: []
    };
  },
  mounted() {
    this.getBanner();
  },
  methods: {
    getBanner() {
      this.$axios
        .post("https://35666j.com/index.php/index/webs/banner")
        .then(res => {
          this.images = res.data.data.banner;
        });
    }
  },
  components: {}
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
