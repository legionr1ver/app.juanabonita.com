<script>
import global from './../../js/global';
import Input from './../components/Input.vue'
import Button from './../components/Button.vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faBars } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBars)

export default {
  components: {
    CustomInput: Input,
    CustomButton: Button,
    FontAwesomeIcon,
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
      global,
      articulos: [],
    }
  },
  methods: {
    
  },
}
</script>

<template>
  <nav>

  </nav>
  <section>
    <header class="flex text-2xl bg-primary-container px-4 py-2 mb-5">
      <custom-button class="me-3">
        <font-awesome-icon :icon="['fas', 'bars']" />
      </custom-button>
      <div class="text-on-primary-container">
        <h1>Juana Bonita</h1>
      </div>
    </header>
    <main>
      qwepoiquwpeoiquwepouqweqwe
    </main>
  </section>
</template>

<style></style>