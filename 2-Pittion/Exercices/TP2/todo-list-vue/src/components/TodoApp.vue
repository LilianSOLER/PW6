<template>
  <div class="container">
    <h2>{{ title }}</h2>
  </div>
</template>

<script>
export default {
  title: '',
  props: {
    title: String
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.container {
  margin: 0 auto;
  max-width: 600px;
}

.container h2 {
  text-align: center;
}
</style>
