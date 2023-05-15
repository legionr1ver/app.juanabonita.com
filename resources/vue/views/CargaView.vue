<script>
import global from './../../js/global';
import Input from './../components/Input.vue'
import Button from './../components/Button.vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faBars, faRightFromBracket } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBars,faRightFromBracket);

export default {
  components: {
    CustomInput: Input,
    CustomButton: Button,
    FontAwesomeIcon,
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
      global,
      campanias: [],
    }
  },
  methods: {
    async logout(){
      try {
        await axios.post('/logout');
        this.global.user = null;
        this.$router.push({name:'login'});

      } catch (error) {
        console.log(`Error al logout: ${error.response.data.message}`);
      }
    },
  },
}
</script>

<template>
  <nav>

  </nav>
  <section>
    <header class="flex items-center text-2xl bg-primary-container px-4 py-2 mb-5">
      <custom-button class="me-3">
        <font-awesome-icon :icon="['fas', 'bars']" />
      </custom-button>
      <div class="text-on-primary-container">
        <h1>Juana Bonita</h1>
      </div>
      <font-awesome-icon @click="logout" class="ms-auto text-on-primary-container text-sm cursor-pointer" :icon="['fas', 'right-from-bracket']" />
    </header>
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
  </section>
</template>

<style></style>