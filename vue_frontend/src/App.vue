<template>
  <div id="app">
    <b-card title="Card Title" no-body>
      <TheNavBar />
      <b-card-body>
        <transition name="fade">
          <router-view></router-view>
        </transition>
      </b-card-body>
    </b-card>
  </div>
</template>

<script>
import TheNavBar from "./containers/TheNavBar";
export default {
  name: "App",

  components: {
    TheNavBar,
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
  /* margin-top: 60px; */
}
</style>
