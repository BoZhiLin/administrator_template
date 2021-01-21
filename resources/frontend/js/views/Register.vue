<template>
  <b-container fluid class="bg-img1 bg-img">
    <div class="box">
      <b-card style="width: 26rem">
        <b-form @submit.stop.prevent>
          <b-card-text class="my-1 logo">
            <b-icon icon="outlet" variant="info" font-scale="3.2"></b-icon>
            <h2><i>建立帳號</i></h2>
          </b-card-text>
          <b-card-text>
            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">姓名:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input
                  id="input-none"
                  size="sm"
                  v-model="name"
                  :state="null"
                  placeholder="Name"
                ></b-form-input>
                <span
                  class="invalid-feedback1"

                  :state="validation"
                >
                  {{ inputError.name }}
                </span>
              </b-col>
            </b-row>

            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">生日:</label>
              </b-col>
              <b-col sm="9">
                <b-form-datepicker
                  id="example-datepicker"
                  size="sm"
                  v-model="birthday"
                  :state="null"
                  placeholder="Birthday"
                ></b-form-datepicker>
                <span
                  class="invalid-feedback1"

                  :state="validation"
                >
                  {{ inputError.birthday }}
                </span>
              </b-col>
            </b-row>

            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">性別:</label>
              </b-col>
              <b-col sm="9">
                <b-form-select
                  id="input-none"
                  size="sm"
                  v-model="gender"
                  :options="options"
                  placeholder="Gender"
                ></b-form-select>
                <span
                  class="invalid-feedback1"

                  :state="validation"
                >
                  {{ inputError.gender }}
                </span>
              </b-col>
            </b-row>

            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">暱稱:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input
                  id="input-nickname"
                  size="sm"
                  v-model="nickName"
                  :state="null"
                  placeholder="NickName"
                ></b-form-input>
                <span
                  class="invalid-feedback1"

                  :state="validation"
                >
                  {{ inputError.nickname }}
                </span>
              </b-col>
            </b-row>

            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">信箱:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input
                  id="input-none"
                  size="sm"
                  v-model="email"
                  :state="null"
                  placeholder="Email"
                ></b-form-input>
                <span
                  class="invalid-feedback1"

                  :state="validation"
                >
                  {{ inputError.email }}
                </span>
              </b-col>
            </b-row>

            <b-row class="my-1">
              <b-col sm="3">
                <label for="input-none">密碼:</label>
              </b-col>
              <b-col sm="9">
                <b-form-input
                  type="password"
                  id="text-password"
                  size="sm"
                  v-model="password"
                  :state="null"
                  placeholder="Password"
                ></b-form-input>
                <span
                  class="invalid-feedback1"

                  :state="validation"
                >
                  {{ inputError.password }}
                </span>
              </b-col>
            </b-row>
          </b-card-text>

          <b-button
            type="submit"
            @click="$router.push({ path: '/login' })" style="margin-right:100px"
            variant="primary"
            >登入</b-button
          >

          <b-button type="submit" @click="register" variant="primary" 
            >註冊</b-button
          >
        </b-form>
      </b-card>
    </div>
  </b-container>
</template>

<script>
import defined from "../tools/defined.js";
import api from "../tools/api.js";

export default {
  data() {
    return {
      validation: "",
      idChange: "",
      name: "",
      birthday: "",
      gender: "",
      nickName: "",
      email: "",
      password: "",
      options: [
        { value: "MALE", text: "男性" },
        { value: "FAMALE", text: "女性" },
        { value: "OTHERS", text: "其他" },
      ],
      inputError:[],
    //   errorStatus: [false, false, false, false, false, false],
      text: [],
    };
  },
  watch: {
    birthday(birthday) {
      if (this.birthday !== "") {
        // this.errorStatus[5] = false;
        this.inputError.birthday = "";
      }
    },
    name(name) {
      if (this.name !== "") {
        // this.errorStatus[5] = false;
        this.inputError.name = "";
      }
    },
    gender(gender) {
      if (this.gender !== "") {
        // this.errorStatus[5] = false;
        this.inputError.gender = "";
      }
    },
    nickName(nickName) {
      if (this.nickName !== "") {
        // this.errorStatus[5] = false;
        this.inputError.nickName = "";
      }
    },
    email(email) {
      if (this.email !== "") {
        // this.errorStatus[5] = false;
        this.inputError.email = "";
      }
    },
    password(password) {
      if (this.password !== "") {
        // this.errorStatus[5] = false;
        this.inputError.password = "";
      }
    },
  },
  methods: {
    register: function () {
      api
        .userRegister({
          name: this.name,
          birthday: this.birthday,
          gender: this.gender,
          nickName: this.nickName,
          email: this.email,
          password: this.password,
        })
        .then(({ data }) => {
            console.log(data.msg.password[0 ]);
            this.inputError = data.msg;
          
        })
        .catch(({ response }) => {
          //
        });
    },
  },
};
</script>

<style>
.logo {
  text-align: center;
}
.logo h2 {
  font-weight: bold;
  margin: 5px 0px 30px 0px;
}
.invalid-feedback1 {
  display: block;
  width: 100%;
  margin-top: 0.25rem;
  font-size: 80%;
  color: #dc3545 !important;
}
</style>