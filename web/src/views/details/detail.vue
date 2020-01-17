<template>
  <div class="cpages detail">
    <van-nav-bar :left-text="leftText" left-arrow @click-left="onClickLeft" />
    <van-pull-refresh v-model="isLoading" @refresh="onRefresh">
      <div class="detail_box">
        <h4 class="det_title">这是很长的标题</h4>
        <div class="det_ass">
          <span class="det_ass_author">{{author}}</span>
          <span class="det_ass_time">今天</span>
        </div>
        <div class="det_con">
          原本想写个更加标题党的：《2020年你为什么还在用10年前的思路学习前端？》
          不过本文更多的还是想给大家带来下一个时代前端开发学习和进阶的思考，而不是纯标题党。就像今年前端领域发生了很多事情，却没有了前几年的热闹非凡的感觉：
          Angular & React & Vue三大框架稳定发展，不再有刻意吸引眼球的无意义争论；
          ES6普及和浏览器对标准支持的增强，各种语言和Web的基础知识逐渐成为合格前端的标配；
          Hybrid和Native并行演进，工程化的前端架构设计逐步在各个项目中普及；
          甚至涉及后端的Node、Ngnix等，也成为技术人员必知必会的领域知识。
          如今也甚少听到前后端分离、前端工程化等推广，原因无非是大型前端项目早已普及工程化的前端架构，而且更多的前端大牛们都已经在实践大前端体系化的架构设计。
          可以预想，前端开发已经开始像后端开发一样，在要求语言和技术基础上，对规模化的实践和企业级的流程成为更重要的需求。
          2019年缩减HC、裁员不绝于耳，大家都是人心惶惶，年前如此。想必马上到来的2020年又是一场更为惨烈的江湖厮杀。各大前端社区里，面试题整理的文章层出不穷，知识整理的内容每天都在刷屏。准备面试开始变成了重复性的刷题背题，然而每次面试前都要现找面试题，而且答案也不是现成的，这样重复的事情在不知不觉中浪费你很多时间。
          著名学者文森特·赖安·拉吉罗的《思考的艺术》一书中有这样的总结：
          人的思维过程是创造性思维和批判性思维的融合，前者强调的是思维的高大宽深，后者强调的是稳准狠快。
          Hybrid和Native并行演进，工程化的前端架构设计逐步在各个项目中普及；
          甚至涉及后端的Node、Ngnix等，也成为技术人员必知必会的领域知识。
          如今也甚少听到前后端分离、前端工程化等推广，原因无非是大型前端项目早已普及工程化的前端架构，而且更多的前端大牛们都已经在实践大前端体系化的架构设计。
          可以预想，前端开发已经开始像后端开发一样，在要求语言和技术基础上，对规模化的实践和企业级的流程成为更重要的需求。
          2019年缩减HC、裁员不绝于耳，大家都是人心惶惶，年前如此。想必马上到来的2020年又是一场更为惨烈的江湖厮杀。各大前端社区里，面试题整理的文章层出不穷，知识整理的内容每天都在刷屏。准备面试开始变成了重复性的刷题背题，然而每次面试前都要现找面试题，而且答案也不是现成的，这样重复的事情在不知不觉中浪费你很多时间。
          著名学者文森特·赖安·拉吉罗的《思考的艺术》一书中有这样的总结：
          人的思维过程是创造性思维和批判性思维的融合，前者强调的是思维的高大宽深，后者强调的是稳准狠快。
        </div>
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
      isLoading: false
    };
  },
  mounted() {
    window.addEventListener("scroll", this.scrollToTop, true);
  },
  methods: {
    scrollToTop(e) {
      if (e.target.scrollTop > 0) {
        this.leftText = this.author;
      } else {
        this.leftText = "";
      }
    },
    onClickLeft() {
      this.$router.push("/");
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