<script>
import Button from './../components/Button.vue'

export default {
  components: {
    CustomButton: Button,
  },
  async created(){
    try {
      const response = await axios.get('/api/campanias-habilitadas');
      this.campanias = response.data;

    } catch (error) {
      
    }
  },
  data() {
    return {
      campanias: [],
    }
  },
}
</script>

<template>
  <main>
    <div id="campanias" class="p-4 space-y-7">
      <div v-for="campania in campanias" class="text-2xl bg-tertiary-container text-on-tertiary-container p-8 rounded-md flex items-center">
        <div class="text-on-primary-container">
          <h2 class="text-sm font-bold">Campaña {{ campania.id_web_campanias }}</h2>
          <small class="text-xs">Fecha de inicio: {{ (new Date(campania.fecha_inicio)).toLocaleDateString() }}</small>
        </div>
        <router-link :to="`/carga/${campania.id_web_campanias}`" class="ms-auto text-xs bg-secondary text-on-secondary px-3 py-2 rounded-full">
          Seleccionar
        </router-link>
      </div>
    </div>
  </main>
</template>

<style></style>