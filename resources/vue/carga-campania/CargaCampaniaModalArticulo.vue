<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faXmark } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faXmark);

export default {
  components: {
    FontAwesomeIcon,
  },
  props: {
    articulo: {
      required: true,
    },
  },
  emits: [
    'update:articulo',
  ],
  data() {
    return {
      loading: false,
      src: null,
      message: null,
    }
  },
  watch: {
    async articulo(newValue, oldValue){
      this.message = null;

      if( newValue === null ){
        URL.revokeObjectURL(this.src);
        return;
      }

      try {
        this.loading = true;
        this.$refs.dialog.showModal();

        const response = await axios.get(`/api/imagen/codigo8/${this.articulo.cod11.slice(0,8)}`,{
          'responseType': 'blob',
        });

        this.src = URL.createObjectURL(response.data);

      } catch (error) {
        this.message = 'No se encontro imagen del artículo.';
        
      }finally {
        this.loading = false;
      }
    },
  },
  mounted(){
    this.$refs.dialog.addEventListener('close', () => this.$emit('update:articulo', null));
  },
}
</script>

<template>
  <dialog ref="dialog" class="rounded-lg">
    <header class="mb-8 flex items-center">
      <h2 v-if="articulo" class="text-xs text-primary me-4">{{ articulo.descripcion }} ({{ articulo.cod11 }})</h2>
      <form method="dialog" class="ms-auto me-1">
        <button>
          <font-awesome-icon :icon="['fas', 'xmark']" />
        </button>
      </form>
    </header>

    <svg v-if="loading" class="animate-spin h-14 w-14 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>

    <template v-else>
      <img :src="src" />
      <p v-if="message" class="p-2 rounded-lg bg-error-container text-on-error-container">{{ message }}</p>
    </template>

  </dialog>
</template>

<style scoped>
::backdrop {
  background-color: rgba(0,0,0,0.3);
}
</style>