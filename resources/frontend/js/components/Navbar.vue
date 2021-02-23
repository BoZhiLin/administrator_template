<template>
  <div >
    <b-navbar v-show="$store.state.logined" type="dark" variant="dark" class="tet">
      <b-navbar-nav>
        <b-nav-item href="#">Home</b-nav-item>

        <!-- Navbar dropdowns -->
        <b-nav-item-dropdown text="Lang" right>
          <b-dropdown-item href="#">EN</b-dropdown-item>
          <b-dropdown-item href="#">ES</b-dropdown-item>
          <b-dropdown-item href="#">RU</b-dropdown-item>
          <b-dropdown-item href="#">FA</b-dropdown-item>
        </b-nav-item-dropdown>

        <b-nav-item-dropdown text="User" right>
          <b-dropdown-item href="#">Account</b-dropdown-item>
          <b-dropdown-item href="#">Settings</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
      <b-navbar-nav class="ml-auto">
        <b-button
          size="md"
          class="my-2 my-sm-0 log-btn"
          type="submit"
          @click="$router.push({ path: '/login' })"
          >Login</b-button
        >
      </b-navbar-nav>
    </b-navbar>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // logined:this.$store.stats.logined,
    };
  },
  methods: {},
};
</script>

<style>
.tet {
  position: fixed;
  top: 0;
  right: 0;
  left: 0;
  z-index: 100;
  background: linear-gradient(#343a40, transparent) !important;
}
.log-btn {
  color:#fd5068 !important ;
  background-color: aliceblue!important;
  transition: all 0.5s;
}
.log-btn:hover {
  background: linear-gradient(45deg, Crimson, darksalmon) !important;
  color:aliceblue !important
}
</style>
