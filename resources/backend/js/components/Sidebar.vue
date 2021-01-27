<template>
  <div class="sidebar">
    <div class="title">
      後台管理
    </div>
    <div class="menu-items">
      <router-link to="/admin/dashboard" active-class="active" tag="button" exact class="side-btn">
        <b-icon icon="grid-fill"></b-icon>  
         主頁
      </router-link>
      <router-link to="/admin/settings" active-class="active" tag="button" exact class="side-btn">
        <b-icon icon="file-person"></b-icon>
         個人中心
      </router-link>
      <router-link to="/admin/administrators" active-class="active" tag="button" exact class="side-btn">
        <b-icon icon="tools"></b-icon>
         後台人員
      </router-link>
      <router-link to="/admin/announcements" active-class="active" tag="button" exact class="side-btn">
        <b-icon icon="chat-right-dots-fill"></b-icon>
         公告管理
      </router-link>
      <router-link to="/admin/banners" active-class="active" tag="button" exact class="side-btn">
        <b-icon icon="files"></b-icon>
         Banner管理
      </router-link>
      <router-link to="/admin/accounts" active-class="active" tag="button" exact class="side-btn">
        <b-icon icon="file-person-fill"></b-icon>
         會員管理
      </router-link>
      <b-button type="submit" @click="adminLogout" variant="primary" block>
        登出
      </b-button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import defined from "../tools/defined.js";

export default {
  methods: {
    adminLogout() {
      axios
        .post("/admin/api/auth/logout", {
        })
        .then(({ data }) => {
          console.log(data);
          const response = data;
          const credential = response.data;
          if (response.status === defined.response.SUCCESS) {
            localStorage.remove("access_token");
            localStorage.remove("expired_at");
            this.$router.push({ path: "/admin/login" });
          }
        });
    },
  },
}
</script>

<style scoped>
.title {
  color: white;
  font-size: 24px;
  margin-top: 10px;
}
.menu-items {
  display: flex;
  flex-direction: column;
}
.side-btn {
  text-align: left;
  border: none;
  padding: 16px 0px 16px 25px;
  cursor: pointer;
  font-size: 16px;
  font-weight: 500;
  color: white;
  background-color: transparent;
}
.side-btn:focus {
  outline: none;
}
.side-btn.active {
  position: relative;
  background-color: white;
  color: #283443;
  font-weight: 600;
  border-radius: 30px 0 0 30px;
}
</style>