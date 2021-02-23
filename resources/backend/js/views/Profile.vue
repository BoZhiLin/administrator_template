<template>
  <div>
    <Layout>
      <div class="profile">
        Profile
      </div>
    </Layout>
  </div>
</template>

<script>
import Layout from "@/components/Layout";

export default {
  components: {
    Layout,
  },
  created() {
    // 
  },
}
</script>

<style lang="scss" scoped>
.profile {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  width: 100%;
  font-size: 40px;
  color: rgb(167, 167, 167);
  font-weight: 600;
}
</style>