<template>
  <div class="cpages register">
    <van-nav-bar title="用户注册" left-arrow @click-left="onClickLeft" />
    <div class="reg_field">
      <div class="sp_input">
        <van-field v-model="username" placeholder="请输入用户名" />
      </div>
      <div class="sp_input sp_input_code">
        <van-field type="number" v-model="code" placeholder="请输入验证码" />
        <van-button color="#ff6880" block>获取验证码</van-button>
      </div>
      <div class="sp_input">
        <van-field type="password" v-model="password" placeholder="请输入密码(6-16位)" />
      </div>
      <div class="sp_input">
        <van-field type="password" v-model="password2" placeholder="请输入确认密码(6-16位)" />
      </div>
      <div class="sp_btn">
        <van-button size="large" color="#ff6880">确认修改</van-button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      username: "",
      password: "",
      password2: "",
      code: "",
    }
  },
  mounted() {},
  methods: {
    onClickLeft() {
      this.$router.push("/login");
    }
  },
  components: {}
}
</script>
<style lang="scss" scoped>
.reg_field{
  padding: 15px;
  height: 100%;
  background: #f2f2f2;
}
.sp_input{
  margin-bottom: 15px;
}
.sp_input_code{
  display: flex;
  align-items: center;
  button{
    padding: 0;
    margin-left: 15px;
  }
}
.sp_btn{
  margin-top: 40px;
}
</style>