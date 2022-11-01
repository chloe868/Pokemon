<template>
	<div id="bg">
    <Navbar />
    <!-- <router-link to="/login">Login</router-link> |
    <router-link to="/register">Register</router-link> -->
    <router-view />
  </div>
</template>
<script>
import Navbar from "../components/Navbar.vue";
export default {
  components: {
    Navbar
  }
};
</script>
<style scoped>
#bg {
  /* height: 200px;
  background-color: red; */
  min-height: 100vh;
  background-image: linear-gradient(red, yellow);
}
</style>
