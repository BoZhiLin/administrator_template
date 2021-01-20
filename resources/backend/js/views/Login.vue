<template>
  <div>
  <b-card 
    bg-variant="light"
    header="Login"
    class="text-center"
    style="max-width: 25rem;"
  >
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
          placeholder="Enter your password"
          v-model="password"
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" @click="adminLogin" variant="primary" block >Login</b-button>
  </b-card>
</div>
</template>

<script>
import axios from 'axios';
import router from '../router/index'

export default {
  name: "Login",
  data: function() {
    return {
        username: "",
        password: "",
    }
  },
  methods: {
    adminLogin : function () {
      axios.post('/admin/api/auth/login', {
      username: this.username,
      password: this.password
      })
      .then(function (response) {
        const success = response.data;
        const credential = success.data.credential;
        
        if (success.status === 0) {
              localStorage.setItem("access_token", credential.access_token);
              localStorage.setItem("expired_at", credential.expired_at);
              router.push({ path: "/admin/dashboard" });
            }
        })
      .catch(function (error) {
        alert('Error');
      });
    }
  },
};
</script>

<style lang="scss">
$light_gray:rgb(17, 8, 8);

  .card {
    position: absolute;;
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