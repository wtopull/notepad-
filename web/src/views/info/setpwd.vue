<template>
  <div class="cpages setpwd">
    <van-nav-bar title="忘记密码" left-arrow @click-left="onClickLeft" />
    <div class="sp_field">
      <div class="sp_input">
        <van-field  type="number" v-model="username" placeholder="请输入用户名" />
      </div>
      <div class="sp_input sp_input_code">
        <van-field v-model="code" placeholder="请输入验证码" />
        <van-button color="#ff6880" block>获取验证码</van-button>
      </div>
      <div class="sp_input">
        <van-field type="password" v-model="password" placeholder="新密码(6-16位)" />
      </div>
      <div class="sp_input">
        <van-field type="password" v-model="newPassword" placeholder="确认密码(6-16位)" />
      </div>
      <div class="sp_btn">
        <van-button size="large" color="#ff6880">提交</van-button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data () {
    return {
      username: "",
      code: "",
      password: "",
      newPassword: ""
    }
  },
  mounted() {},
  methods: {
    onClickLeft() {
      this.$router.push("/login");
    },
  },
  components: {}
}
</script>
<style lang="scss" scoped>
.sp_field{
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