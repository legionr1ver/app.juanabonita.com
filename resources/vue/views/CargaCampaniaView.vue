<script>
import Input from './../components/Input.vue'
import Button from './../components/Button.vue'
import ModalImagenArticulo from './../components/ModalImagenArticulo.vue'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faAngleLeft, faTrash, faXmark } from '@fortawesome/free-solid-svg-icons'
import { faCircleCheck, faImage, faFloppyDisk, faCircleXmark } from '@fortawesome/free-regular-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faAngleLeft,faTrash,faCircleCheck,faImage,faFloppyDisk,faCircleXmark,faXmark);

export default {
  components: {
    CustomInput: Input,
    CustomButton: Button,
    FontAwesomeIcon,
    ModalImagenArticulo,
  },
  data() {
    return {
      articulos: [],
      mapTipos: null,
      mapColores: null,

      codigo: '1023',
      tipo: '05',
      color: '02',
      talle: '001',
      cantidad: 1,
      itemKey: 0, // Solo para agregar al :key dentro del TransitionGroup 
      pedido: [],

      successMessage: '',
      errorMessage: '',

      articuloImagen: null,
    }
  },
  async created(){
    try {
      const [rArticulos,rTipos,rColores,rTalles] = await Promise.all([
        axios.get(`/api/articulo?id_web_campanias=${this.$route.params.id}`),
        axios.get(`/api/tipo?id_web_campanias=${this.$route.params.id}`),
        axios.get(`/api/color?id_web_campanias=${this.$route.params.id}`),
      ]);

      this.mapTipos = new Map( rTipos.data.map(t => [t.codigo_tipo, t.descripcion]) );
      this.mapColores = new Map( rColores.data.map(t => [t.codigo_color, t.descripcion]) );

      this.articulos = rArticulos.data.map(a => {
        const codigo = a.cod11.slice(0,4);
        const tipo = a.cod11.slice(4,6);
        const color = a.cod11.slice(6,8);
        const talle = a.cod11.slice(8,11);

        return {
          ...a,
          codigo,
          tipo,
          color,
          talle,
        };
      });
      
    } catch (error) {
      console.log(error);
    }
  },
  computed: {
    listCodigos(){
      const list = new Set();
      this.articulos.forEach(a => list.add(a.codigo));
      return list;
    },
    listTipos(){
      const list = new Set();
      this.articulos
        .filter(a => a.codigo === this.codigo)
        .forEach(a => list.add(a.tipo));
      const ret = [];
      list.forEach(v => ret.push({codigo: v, descripcion: this.mapTipos.get(v)}));
      return ret;
    },
    listColores(){
      const list = new Set();
      this.articulos
        .filter(a => a.codigo === this.codigo && a.tipo === this.tipo)
        .forEach(a => list.add(a.color));
      const ret = [];
      list.forEach(v => ret.push({codigo: v, descripcion: this.mapColores.get(v)}));
      return ret;
    },
    listTalles(){
      const list = new Set();
      this.articulos
        .filter(a => a.codigo === this.codigo && a.tipo === this.tipo && a.color === this.color)
        .forEach(a => list.add(a.talle));
      return list;
    },
  },
  methods: {
    agregarArticulo(){
      this.successMessage = '';
      this.errorMessage = '';

      const articulo = this.articulos.find(a => 
        a.codigo === this.codigo 
        && a.tipo === this.tipo
        && a.color === this.color
        && a.talle === this.talle);

      if(!articulo){
        this.errorMessage = 'No existe el articulo.';
        return;
      }

      this.pedido.push({key: ++this.itemKey,articulo,cantidad: this.cantidad,tipo: 'normal'});

      this.codigo = '';
      this.tipo = '';
      this.color = '';
      this.talle = '';
      this.cantidad = 1;

      document.getElementById('codigo').focus();
    },
    async guardar(){
      try {
        this.successMessage = '';
        this.errorMessage = '';
        this.$refs.dialog.showModal();

        await axios.post('/api/pedido', {
          id_web_campanias: this.$route.params.id,
          items: this.pedido.map( item => ({
            cod11: item.articulo.cod11,
            cantidad: item.cantidad,
            tipo: item.tipo,
          })),
        });

        this.pedido = [];
        this.codigo = '';
        this.tipo = '';
        this.color = '';
        this.talle = '';
        this.cantidad = 1;

        this.successMessage = 'Pedido guardado.';

      } catch (error) {
        this.errorMessage = error.response.data.message;

      }finally {
        this.$refs.dialog.close();
      }
    }
  },
}
</script>

<template>
  <main>

    <dialog ref="dialog" class="bg-transparent">
      <p>
        <svg class="animate-spin h-14 w-14 text-on-primary me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </p>
    </dialog>

    <ModalImagenArticulo v-model:articulo="articuloImagen" />

    <button @click="guardar" class="fixed right-5 rounded-full bg-primary text-on-primary p-4 flex items-center justify-center text-3xl shadow">
      <font-awesome-icon :icon="['far', 'floppy-disk']" />
    </button>

    <header class="p-5 flex text-2xl mb-2">
      <router-link class="me-2 cursor-pointer" :to="{name:'carga'}">
        <font-awesome-icon :icon="['fas', 'angle-left']" />
      </router-link>

      <h2>Campaña {{ $route.params.id }}</h2>
    </header>

    <p v-if="successMessage" class="flex mx-5 mb-5 py-2 px-4 bg-green-200 text-green-950 rounded-lg border-solid border-green-950 border">
      <div class="flex-1">
        {{ successMessage }}
      </div>
      <div class="flex-initial flex items-center">
        <font-awesome-icon class="w-5 h-5" :icon="['far', 'circle-check']" />
      </div>
    </p>

    <p v-if="errorMessage" class="flex mx-5 mb-5 py-2 px-4 bg-error-container text-on-error-container rounded-lg border-solid border-error border">
      <div class="flex-1">
        {{ errorMessage }}
      </div>
      <div class="flex-initial flex items-center">
        <font-awesome-icon class="w-5 h-5" :icon="['far', 'circle-xmark']" />
      </div>
    </p>

    <h3 class="px-5 mb-1 text-md">Nuevo Artículo</h3>

    <datalist id="codigos">
      <option v-for="listCodigo in listCodigos" :value="listCodigo">{{ listCodigo }}</option>
    </datalist>
    <datalist id="tipos">
      <option v-for="listTipo in listTipos" :value="listTipo.codigo">{{ `${listTipo.codigo} - ${listTipo.descripcion}` }}</option>
    </datalist>
    <datalist id="colores">
      <option v-for="listColor in listColores" :value="listColor.codigo">{{ `${listColor.codigo} - ${listColor.descripcion}` }}</option>
    </datalist>
    <datalist id="talles">
      <option v-for="listTalle in listTalles" :value="listTalle">{{ listTalle }}</option>
    </datalist>

    <form @submit.prevent="agregarArticulo" class="grid gap-1 px-5 mb-8">
      <custom-input autofocus v-model.trim="codigo" autocomplete="off" list="codigos" id="codigo" type="text" placeholder="Codigo" required />
      <custom-input v-model.trim="tipo" autocomplete="off" list="tipos" id="tipo" type="text" placeholder="Tipo" required />
      <custom-input v-model.trim="color" autocomplete="off" list="colores" id="color" type="text" placeholder="Color" required />
      <custom-input v-model.trim="talle" autocomplete="off" list="talles" id="talle" type="text" placeholder="Talle" required />
      <custom-input v-model.number="cantidad" autocomplete="off" id="cantidad" type="number" placeholder="Cantidad" required min="1" step="1" />
      <div class="grid grid-cols-2 gap-2">
        <custom-button type="submit" class="bg-secondary text-on-secondary">
          <font-awesome-icon :icon="['far', 'circle-check']" />
        </custom-button>
        <custom-button type="reset" class="bg-secondary text-on-secondary">
          <font-awesome-icon :icon="['fas', 'trash']" />
        </custom-button>
      </div>
    </form>

    <h3 class="px-5 mb-1 text-md">Tu pedido</h3>

    <p v-if="pedido.length === 0" class="px-5 text-center font-bold">No hay ningún artículo seleccionado.</p>

    <TransitionGroup name="list" tag="ul" class="mx-5 py-2 bg-surface text-on-surface text-sm space-y-4 divide-y-2">
      <li v-for="(item,index) in pedido" :key="item.key">
        <div class="flex mb-1">
          <span class="flex-1 p-1">{{ item.articulo.cod11 }}-{{ item.articulo.descripcion }}</span>
          <span class="flex-initial">Cant: {{ item.cantidad }}</span>
        </div>
        <div class="flex">
          <select v-model="item.tipo" class="flex-1 me-2 p-1 text-outline border border-outline border-solid rounded-md">
            <option value="normal">Normal</option>
            <option value="muestrario">Muestrario</option>
            <option value="cuotas">Cuotas</option>
          </select>
          <custom-button @click="articuloImagen = item.articulo" type="button" class="bg-secondary text-on-secondary flex-initial me-2">
            <font-awesome-icon :icon="['far', 'image']" />
          </custom-button>
          <custom-button @click="pedido.splice(index,1)" type="button" class="bg-secondary text-on-secondary flex-initial">
            <font-awesome-icon :icon="['fas', 'trash']" />
          </custom-button>
        </div>
        <div class="flex p-2">
          <span class="flex-1">PU: ${{ parseFloat(item.articulo.precio).toFixed(2) }}</span>
          <span class="flex-initial ms-auto">Sub: ${{ (parseFloat(item.articulo.precio) * item.cantidad).toFixed(2) }}</span>
        </div>
      </li>
    </TransitionGroup>
  </main>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

::backdrop {
  background-color: rgba(0,0,0,0.3);
}
</style>