<template>
  <div class="sidebar">
    <div class="title">後台管理</div>
    <div class="menu-items">
      <router-link
        :to="{ name: 'admin.dashboard' }"
        active-class="active"
        tag="button"
        exact
        class="side-btn"
      >
        <b-icon icon="grid-fill"></b-icon>
        主頁
      </router-link>
      <router-link
        :to="{ name: 'admin.profile' }"
        active-class="active"
        tag="button"
        exact
        class="side-btn"
      >
        <b-icon icon="file-person"></b-icon>
        個人中心
      </router-link>
      <router-link
        :to="{ name: 'admin.administrators' }"
        active-class="active"
        tag="button"
        exact
        class="side-btn"
      >
        <b-icon icon="tools"></b-icon>
        後台人員
      </router-link>
      <router-link
        :to="{ name: 'admin.announcements' }"
        active-class="active"
        tag="button"
        exact
        class="side-btn"
      >
        <b-icon icon="chat-right-dots-fill"></b-icon>
        公告管理
      </router-link>
      <router-link
        :to="{ name: 'admin.banners' }"
        active-class="active"
        tag="button"
        exact
        class="side-btn"
      >
        <b-icon icon="files"></b-icon>
        Banner管理
      </router-link>
      <router-link
        :to="{ name: 'admin.users' }"
        active-class="active"
        tag="button"
        exact
        class="side-btn"
      >
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
      axios.post("/admin/api/auth/logout", {}, {
          headers: {
            "Authorization": `Bearer ${localStorage["access_token"]}`
          }
        })
        .then(({ data }) => {
          if (data.status === defined.response.SUCCESS) {
            localStorage.removeItem("access_token");
            localStorage.removeItem("expired_at");
            this.$router.push({ name: "admin.login" });
          }
        });
    },
  },
};
</script>

<style lang="scss" scoped>
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