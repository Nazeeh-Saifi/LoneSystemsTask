<template>
  <div class="hello">
    <h1>L-one Systems Task</h1>
    <h3>#in order to run this project please follow the steps:</h3>

    <ul>
      <li>add .env file and insert your database credentials</li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  props: {
    msg: String,
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  padding: 0;
}
li {
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>