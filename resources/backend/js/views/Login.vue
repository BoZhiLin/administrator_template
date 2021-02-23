<template>
  <div class="login-container">
    <div class="row d-flex justify-content-center">
      <b-card
        bg-variant="light"
        header="後台登入"
        class="text-center"
        style="max-width: 25rem"
      >
        <b-form @submit.stop.prevent>
          <b-input-group class="mb-2">
            <b-input-group-prepend is-text>
              <b-icon icon="person-fill"></b-icon>
            </b-input-group-prepend>
            <b-form-input
              id="username"
              name="username"
              placeholder="請輸入使用者帳號"
              v-model="username"
            ></b-form-input>
          </b-input-group>

          <b-input-group class="mb-2">
            <b-input-group-prepend is-text>
              <b-icon icon="lock-fill"></b-icon>
            </b-input-group-prepend>
            <b-form-input
              id="password"
              name="password"
              type="password"
              placeholder="請輸入使用者密碼"
              v-model="password"
            ></b-form-input>
          </b-input-group>
          <b-button type="submit" @click="Login" variant="primary" block>
            登入
          </b-button>
        </b-form>
      </b-card>
    </div>
  </div>
</template>

<script>
import defined from "@/tools/defined.js";
import api from "@/tools/api.js";

export default {
  data() {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    Login() {
      api
        .adminLogin({
          username: this.username,
          password: this.password,
        })
        .then(({ data }) => {
          const response = data;
          
          if (response.status === defined.response.SUCCESS) {
            localStorage.setItem("access_token", response.data.access_token);
            localStorage.setItem("expired_at", response.data.expired_at);
            this.$router.push({ name: "admin.dashboard" });
          } else {
            this.$swal("錯誤", "帳號或密碼錯誤", "error");
          }
        });
    },
  },
};
</script>

<style lang="scss" scoped>
$bg:#283443;
$light_gray:#110809;

.login-container {
  font-family: "Roboto", sans-serif;
  text-align: center;
  color: #fff;
  background: $bg;
  height: 100vh;
  margin: 0;
  padding: 0px;
  background-attachment: fixed;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.card {
  position: absolute;
  margin: 200px auto;
  box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.6);
}

.card-header {
  font-size: 26px;
  color: $light_gray;
  font-weight: bold;
}

.col-form-label {
  font-weight: bold;
}
</style>