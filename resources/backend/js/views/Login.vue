<template>
  <div class="login-container">
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
            <b-icon icon="envelope-fill"></b-icon>
          </b-input-group-prepend>
          <b-form-input
            id="password"
            name="password"
            type="password"
            placeholder="請輸入使用者密碼"
            v-model="password"
          ></b-form-input>
        </b-input-group>
        <b-button type="submit" @click="adminLogin" variant="primary" block>
          登入
        </b-button>
      </b-form>
    </b-card>
  </div>
</template>

<script>
import axios from "axios";
import defined from "../tools/defined.js";

export default {
  data() {
    return {
      username: "",
      password: "",
    };
  },
  methods: {
    adminLogin() {
      axios
        .post("/admin/api/auth/login", {
          username: this.username,
          password: this.password,
        })
        .then(({ data }) => {
          const response = data;
          const credential = response.data;
          if (response.status === defined.response.SUCCESS) {
            localStorage.setItem("access_token", credential.access_token);
            localStorage.setItem("expired_at", credential.expired_at);
            this.$router.push({ path: "/admin/dashboard" });
          } else if (response.status === defined.response.UNAUTHORIZED) {
            this.$swal("錯誤!", "請重新輸入使用者帳號和密碼!", "error");
          }
        });
    },
  },
};
</script>

<style lang="scss">
$light_gray: rgb(17, 8, 8);

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