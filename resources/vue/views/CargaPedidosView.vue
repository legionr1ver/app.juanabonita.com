<script>
import global from './../../js/global';
import Input from './../components/Input.vue'
import Button from './../components/Button.vue'
import axios from 'axios';

export default {
  components: {
    CustomInput: Input,
    CustomButton: Button,
  },
  data() {
    return {
      global,
    }
  },
  methods: {
    async logOut(){
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
  <div class="min-h-screen flex items-center">
    <div class="max-w-[800px] mx-auto p-3 flex-1">
      <header class="mb-3">
        <h1 class="text-4xl text-center">Carga de Pedidos</h1>
      </header>
      <p>{{ global.user?.nombre || 'No logueado' }}</p>
      <button @click="logOut">LogOut</button>
    </div>
  </div>
</template>

<style></style>