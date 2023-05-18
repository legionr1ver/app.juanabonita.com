<script>
import global from './../js/global.js';

export default {
  data(){
    return {
      global,
      loading: true,
      error: false,
    };
  },
  async created(){
    try {
      await this.getCsrfCookie();
      this.global.user = await this.getLoggeduser();

      if( this.global.user === null ){
        this.$router.push({name:'login'});
      }else{
        this.$router.push({name:'carga'});
      }

    } catch (error) {
      this.error = true;
    } finally {
      this.loading = false;
    }
  },
  mounted(){
    document.addEventListener('unauthenticated', e => {
      
      if( this.$route.name === 'login' )
        return;

      this.global.user = null;
      this.$router.push( {name:'login'} );
    });
  },
  methods: {
    async getCsrfCookie(){
      try {
        const response = await axios.get('/sanctum/csrf-cookie');
      } catch (error) {
        throw `Error al obtener cookie: ${error.response.data.message}`;
      }
    },
    async getLoggeduser(){
      try {
        const response = await axios.get('/api/user');
        return response.data;

      } catch (error) {
        // Unauthenticated
        if( error.response.status === 401 ) return null;
        throw `Error al obtener usuario logueado: ${error.response.data.message}`;
      }
    },
  }
}
</script>

<template>
  <template v-if="!loading">

    <template v-if="!error">
      <router-view name="NavView"></router-view>
      <router-view name="HeaderView"></router-view>
      <router-view></router-view>
    </template>

    <p v-else>Ocurrio un error: {{ this.error }}</p>
  </template>
</template>

<style></style>