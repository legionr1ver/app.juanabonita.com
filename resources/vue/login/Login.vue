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
      loading: false,
    }
  },
  methods: {
    async login(){
      try {
        this.loading = true;

        const response = await axios.post('/login',{
          mail: this.email,
          password: this.password,
        });

        const rUser = await axios.get('/api/user');
        this.global.user = rUser.data;

        this.$router.push({name: 'carga'});

      } catch (error) {
        console.log(error);
        this.error = error.response.data.message;

      } finally {
        this.loading = false;
      }
    },
  },
}
</script>

<template>
  <div class="min-h-[100svh] flex items-center">
    <div class="max-w-[800px] mx-auto p-8 flex-1">
      <header class="mb-10">
        <img class="max-w-full mx-auto" src="images/juana-bonita-logo.png">
      </header>

      <h2 class="text-2xl mb-10">Iniciar sesión</h2>

      <form @submit.prevent="login" class="grid grid-flow-row gap-6">

        <div class="grid gap-1">
          <label for="email" class="text-sm text-outline">Email</label>
          <custom-input id="email" v-model="email" type="text" required />
          <!--p>Algun error</p-->
        </div>

        <div class="grid gap-1">
          <label for="password" class="text-sm text-outline">Password</label>
          <custom-input id="password" v-model="password" type="password" required />
          <!--p>Algun error</p-->
        </div>

        <p v-if="error" class="px-4 py-2 bg-error-container text-on-error-container rounded-md text-sm">{{ error }}</p>

        <custom-button :loading="loading" type="submit">Ingresar</custom-button>
      </form>
    </div>
  </div>
</template>

<style></style>