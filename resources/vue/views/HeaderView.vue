<script>
import global from './../../js/global.js'
import Button from './../components/Button.vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faBars, faRightFromBracket } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBars,faRightFromBracket);

export default {
  components: {
    CustomButton: Button,
    FontAwesomeIcon,
  },
  data(){
    return {
      global,
    };
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
  <header class="flex items-center text-2xl bg-primary-container px-4 py-2 mb-5">
    <custom-button class="me-3">
      <font-awesome-icon :icon="['fas', 'bars']" />
    </custom-button>
    <div class="text-on-primary-container">
      <h1>Juana Bonita</h1>
    </div>
    <font-awesome-icon @click="logout" class="ms-auto text-on-primary-container text-sm cursor-pointer" :icon="['fas', 'right-from-bracket']" />
  </header>
</template>

<style></style>