<template>
  <b-container fluid class="bg-img1 bg-img">
    <div class="box">
      <b-card
        title="Login"
        img-src="https://picsum.photos/600/300/?image=25"
        img-alt="Image"
        img-top
        tag="article"
        style="max-width: 60%"
        class="mb-2"
      >
        <b-form @submit.stop.prevent>
          <b-card-text>
            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">email:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input
                  id="input-none"
                  size="sm"
                  v-model="email"
                  :state="null"
                  placeholder="Email"
                ></b-form-input>
              </b-col>
            </b-row>
            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">Password:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input
                  id="input-none"
                  type="password"
                  size="sm"
                  v-model="password"
                  :state="null"
                  placeholder="Password"
                ></b-form-input>
              </b-col>
            </b-row>
          </b-card-text>

          <b-button type="submit" @click="login" variant="primary">login</b-button>
        </b-form>
      </b-card>
    </div>
  </b-container>
</template>

<script>
import defined from '../tools/defined.js';

export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    login() {
      // url不用打完整的，因為跟後端都在同一個網域底下
      // 盡量不要用你原本的寫法，因為你送出的email跟password會暴露在網址上，有資安疑慮
      // 下面註解掉的是你原本的寫法，可以跟新版的參照一下
      axios
        .post('/api/auth/login', {
          email: this.email,
          password: this.password
        }, {
          headers: {
            Accept: "application/json"
          }
        })
        .then(({ data }) => {
          const response = data;

          if (response.status === defined.response.SUCCESS) {
            localStorage.setItem("access_token", response.data.access_token);
            localStorage.setItem("expired_at", response.data.expired_at);

            // 要登入成功才能到article
            this.$router.push({ path: "article" });
          }
        })
        .catch(({ response }) => {
          // 
        });
    },
    // logined() {
    //   axios({
    //     method: "post",
    //     url: "http://localhost:8000/api/auth/login",
    //     params: {
    //       email: this.email,
    //       password: this.password,
    //     },
    //     headers: {
    //       Accept: "application/json",
    //     },
    //   })
    //     .then((response) => {
    //       console.log(response.data.data);
    //       localStorage.setItem("access_token", response.data.data.credential.access_token)
    //       localStorage.setItem("expired_at", response.data.data.credential.expired_at)
    //       console.log(localStorage.getItem("access_token"));
    //     })
    //     .catch((error) => {
    //       console.log("false");
    //     });
    //   this.$router.push({path:"article"});
    // },
  },
};
</script>

<style>
.box {
  display: flex;
  align-content: center;
  justify-content: center;
}
.bg-img1 {
  background-color: rgba(0, 0, 0, 0.2);
  background-blend-mode: multiply;
  background-position: center center;
  background-size: cover;
  background-image: url("https://images.pexels.com/photos/587835/pexels-photo-587835.jpeg?auto=compress&cs=tinysrgb&dpr=1&w");
  min-height: 50rem !important;
  margin-bottom: 0px !important;
}
</style>
