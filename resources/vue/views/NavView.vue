<script>
import global from './../../js/global.js';

import { library } from '@fortawesome/fontawesome-svg-core'
import { faUser } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUser);

export default {
  components: {
    FontAwesomeIcon,
  },
  data() {
    return {
      global,
    }
  },
}
</script>

<template>
  <div id="nav" class="flex flex-col transition-transform duration-500 ease-in fixed top-0 bottom-0 p-12 bg-primary text-on-primary w-[300px] rounded-tr-lg rounded-br-lg"  :class="{'-translate-x-[300px]': !global.navVisible}">
    <div class="flex-initial flex">
      <div class="flex-initial flex items-center justify-center p-3">
        <font-awesome-icon class="text-3xl" :icon="['far', 'user']" />
      </div>
      <div class="p-3 text-sm flex flex-col">
        <strong>{{ global.user.nombre }}</strong>
        <small>Sin clienta</small>
      </div>
    </div>
    <nav class="flex-1">
      <ul class="text-xl space-y-3 mt-12">
        <li>Pedidos</li>
        <li>Comunidad</li>
        <li>Otra cosa</li>
      </ul>
    </nav>
    <div class="flex-initial">
      Salir
    </div>
  </div>
</template>

<style></style>