<template>
  <div class="card" style="width: 18rem">
    <div class="card-body">
      <h5 class="card-title" @click="redirect('/pokemon_information/' + item.name)">{{item.name.toUpperCase()}}</h5>
    </div>
  </div>
</template>
<script>
export default {
  props: ['item'],
  methods: {
    redirect(route){
      this.$router.push(route)
    }
  }
}
</script>
<style scoped>
.card-title{
    text-align: center;
}
</style>