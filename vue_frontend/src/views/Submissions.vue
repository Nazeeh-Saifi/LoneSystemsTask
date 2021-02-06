<template>
  <h1>submissions of survey {{ id }}</h1>
</template>

<script>
export default {
  name: "Submissions",
  data() {
    return {
      id: this.$route.params.id,
    };
  },
};
</script>

<style>
</style>