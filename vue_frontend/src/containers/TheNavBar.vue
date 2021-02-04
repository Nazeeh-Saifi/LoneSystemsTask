<template>
  <b-navbar type="dark" variant="dark" align="center">
    <!-- <b-navbar-brand href="./assets/lone.png">NavBar</b-navbar-brand> -->
    <b-navbar-brand href="http://www.l-one.de/">
      <img src="../assets/lone.png" alt="l-one systems logo" />
    </b-navbar-brand>

    <b-navbar-nav>
      <b-nav-item :to="{ name: 'Home' }">Home</b-nav-item>
      <b-nav-item :to="{ name: 'AddSurvey' }">Add Survey</b-nav-item>
      <b-nav-item :to="{ name: 'TakeSurvey' }">Take Survey</b-nav-item>
    </b-navbar-nav>
  </b-navbar>
</template>

<script>
export default {
  name: "TheNavBar",
};
</script>

<style>
</style>