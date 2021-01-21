<template>
  <div>
    <b-card
      bg-variant="light"
      header="Login"
      class="text-center"
      style="max-width: 25rem"
    >
      <b-form @submit.stop.prevent>
        <b-form-group
          label="Username:"
          label-for="username"
          label-cols-sm="3"
          label-align-sm="right"
        >
          <b-form-input
            id="username"
            name="username"
            placeholder="Enter your username"
            v-model="username"
          ></b-form-input>
        </b-form-group>

        <b-form-group
          label="Password:"
          label-for="password"
          label-cols-sm="3"
          label-align-sm="right"
        >
          <b-form-input
            id="password"
            name="password"
            type="password"
            placeholder="Enter your password"
            v-model="password"
          ></b-form-input>
        </b-form-group>
        <b-button type="submit" @click="adminLogin" variant="primary" block
          >Login</b-button
        >
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
            this.$swal("Error!", "Incorrect account password!", "error");
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
}
.card-header {
  font-size: 26px;
  color: $light_gray;
  text-align: center;
  font-weight: bold;
}
.col-form-label {
  font-weight: bold;
}
</style>