<template>
  <div class="serves">后端</div>
</template>

<script>
export default {
  name: "home",
  data() {
    return {
      lists: []
    };
  },
  mounted() {
    this.getwebs();
  },
  methods: {
    getwebs() {
      this.$axios
        .post("https://35666j.com/index.php/index/Webs/getwebs")
        .then(res => {
          this.lists = res.data.data;
        });
    },
    toAPP(item, index) {
      window.open(item.urls);
    }
  },
  components: {}
};
</script>
<style lang="scss" scoped>
</style>