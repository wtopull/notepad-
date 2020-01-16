<template>
  <div class="view home">
    <van-swipe :autoplay="3000" :height="150">
      <van-swipe-item v-for="(image, index) in images" :key="index">
        <img v-lazy="image.img" />
      </van-swipe-item>
    </van-swipe>
    <van-notice-bar left-icon="volume-o" :speed="50" background="#ffffff">通知内f容通知内f容通知内f容</van-notice-bar>
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
</style>
