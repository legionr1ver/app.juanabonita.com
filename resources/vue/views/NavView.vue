<script>
import global from './../../js/global.js';

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUser } from '@fortawesome/free-regular-svg-icons'
import { faHouse, faShirt, faInbox, faRightFromBracket } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUser,faHouse,faShirt,faInbox,faRightFromBracket);

export default {
  components: {
    FontAwesomeIcon,
  },
  data() {
    return {
      global,
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
  <div id="nav" class="flex flex-col transition-transform duration-500 ease-in fixed top-0 bottom-0 p-12 bg-primary text-on-primary w-[300px] rounded-tr-lg rounded-br-lg"  :class="{'-translate-x-[300px]': !global.navVisible}">
    <div class="flex-initial flex">
      <div class="flex-initial flex items-center justify-center p-3">
        <font-awesome-icon class="text-4xl" :icon="['far', 'user']" />
      </div>
      <div class="p-3 text-md flex flex-col">
        <strong class="capitalize">{{ global.user.nombre }}</strong>
        <small v-if="!global.user.cliente"></small>
        <small v-else>Zona {{ global.user.cliente.id_cli_zonas || 'Sin Zona' }} - {{ global.user.cliente.numero_cliente || 'Sin Nro Cliente' }}</small>
      </div>
    </div>
    <nav class="flex-initial">
      <ul class="text-xl mt-8 space-y-5">
        <li class="flex items-center hover:text-gray-300 cursor-pointer">
          <font-awesome-icon class="p-2 me-2" :icon="['fas', 'house']" />
          Home
        </li>
        <li class="text-gray-400 flex items-center cursor-not-allowed">
          <font-awesome-icon class="p-2 me-2" :icon="['fas', 'shirt']" />
          Pedidos
        </li>
        <li class="text-gray-400 flex items-center cursor-not-allowed">
          <font-awesome-icon class="p-2 me-2" :icon="['fas', 'inbox']" />
          Comunidad
        </li>
      </ul>
    </nav>
    <div class="flex-initial mt-auto">
      <button @click="logout" class="flex items-center hover:text-gray-300 cursor-pointer text-xl">
        <font-awesome-icon class="p-2 me-2" :icon="['fas', 'right-from-bracket']" />
        Salir
      </button>
    </div>
  </div>
</template>

<style></style>