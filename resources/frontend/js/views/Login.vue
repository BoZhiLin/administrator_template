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
                size="sm"
                v-model="password"
                :state="null"
                placeholder="Password"
              ></b-form-input>
            </b-col>
          </b-row>
        </b-card-text>

        <b-button @click="logined" variant="primary">login</b-button>
      </b-card>
    </div>
  </b-container>
</template>


<script>
export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    logined() {
    //      axios.get('/api/users',{

      // }, {
      //     headers: {
      //         Accept: 'application/json',
      //         Authorization:` Bearer ${localStorage.item}`
      //     }
      // })
      //         .then(response => {

      //         }).catch(error => {

      //         });

      this.$router.push("article");
    },
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
