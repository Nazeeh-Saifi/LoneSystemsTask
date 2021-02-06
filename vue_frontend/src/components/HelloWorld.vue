<template>
  <b-container>
    <b-row>
      <b-col>
        <b-card>
          <template #header>
            <div>
              <h3>L-one Systems Task:</h3>
            </div>
          </template>

          <h5>#in order to run this project please follow the instructions:</h5>
          <b-card>
            <!-- TODO: Complete the instructions -->
            <ol>
              <li>add .env file and insert your database credentials</li>
            </ol>
          </b-card>
        </b-card>
      </b-col>
    </b-row>
  </b-container>
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