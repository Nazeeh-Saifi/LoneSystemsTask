<template>
  <h4>hello {{ id }}</h4>
</template>

<script>
export default {
  name: "TakeSurvey",
  data() {
    return {
      id: this.$route.params.id,
    };
  },
};
</script>

<style>
</style>