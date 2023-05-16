<script>
import Button from './../components/Button.vue'

export default {
  components: {
    CustomButton: Button,
  },
  async created(){
    try {
      const response = await axios.get(`/api/articulo?id_web_campanias=${this.$route.params.id}`);
      this.articulos = response.data;
      
    } catch (error) {
      console.log(error);
    }
  },
  data() {
    return {
      articulos: [],
    }
  },
}
</script>

<template>
  <main>
    qweqweqwe
  </main>
</template>

<style></style>