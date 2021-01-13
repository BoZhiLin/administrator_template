<template>
  <div>
    <navbar />
    <router-view></router-view>
  </div>
</template>

<script>
import Navbar from './Navbar';

export default {
  components: {
    navbar: Navbar
  }    
}
</script>
