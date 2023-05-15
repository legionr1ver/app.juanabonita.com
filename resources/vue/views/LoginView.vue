<script>
import global from './../../js/global.js';
import Input from './../components/Input.vue'
import Button from './../components/Button.vue'

export default {
  components: {
    CustomInput: Input,
    CustomButton: Button,
  },
  data() {
    return {
      global,
      email: 'yesicaaltamira08@gmail.com',
      password: 'del1al6',
      error: '',
    }
  },
  methods: {
    async login(){
      try {
        const response = await axios.post('/login',{
          mail: this.email,
          password: this.password,
        });

        const rUser = await axios.get('/api/user');
        this.global.user = rUser.data;

        this.$router.push({name: 'pedidos-carga'});

      } catch (error) {
        this.error = error.response.data.message;
      }
    },
  },
}
</script>

<template>
  <div class="min-h-screen flex items-center">
    <div class="max-w-[800px] mx-auto p-3 flex-1">
      <header class="mb-3">
        <h1 class="text-4xl text-center">Iniciar Sesión</h1>
      </header>
      <form @submit.prevent="login" class="grid grid-flow-row gap-4">
        <custom-input v-model="email" type="text" required />
        <custom-input v-model="password" type="password" required />
        <p v-if="error" class="px-4 py-2 bg-red-300 rounded-md text-red-900 font-bold">{{ error }}</p>
        <custom-button type="submit">Ingresar</custom-button>
      </form>
    </div>
  </div>
</template>

<style></style>