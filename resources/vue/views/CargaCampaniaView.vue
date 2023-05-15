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
  created(){},
  data() {
    return {
      
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
      qwepoiquwpeoiquwepou
      <div id="campanias" class="p-4 space-y-7">
        <div v-for="campania in campanias" class="text-2xl bg-surface text-on-surface p-4 rounded-md flex items-center">
          <div class="text-on-primary-container">
            <h2 class="text-sm font-bold mb-2">Campaña {{ campania }}</h2>
            <small class="text-xs">Desde 5 de Dic hasta 20 de Enero</small>
          </div>
          <custom-button class="ms-auto text-xs bg-secondary text-on-secondary">Seleccionar</custom-button>
        </div>
      </div>
    </main>
  </section>
</template>

<style></style>