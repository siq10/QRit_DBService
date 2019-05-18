<template>
  <v-app dark>
    <menu-component></menu-component>
    <v-content>
      <v-container fluid>
        <UsersComponent v-if="$store.state.menuchoice===2"></UsersComponent>
        <LogComponent v-if="$store.state.menuchoice===1"></LogComponent>
        <PlacesComponent v-if="$store.state.menuchoice===3"></PlacesComponent>
        <router-view></router-view>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import UsersComponent from './components/UsersComponent.vue'
import MenuComponent from './components/MenuComponent.vue'
import LogComponent from './components/LogComponent.vue'
import PlacesComponent from './components/PlacesComponent.vue'
export default {
  computed: {
    // login(){
    //   console.log("comp" + this.$store.state.showlogin)
    //   return this.$store.state.showlogin
    // }
  },
  name: 'app',
  components: {
      MenuComponent,
      UsersComponent,
      LogComponent,
      PlacesComponent
  }
}
</script>
<style src='vuetify/dist/vuetify.min.css'>
  /* global styles */
</style>
<style scoped>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color:aquamarine;
}
</style>
<style>
  html{
    overflow-y:auto;
  }
  /*v-navigation-drawer v-navigation-drawer--clipped v-navigation-drawer--fixed v-navigation-drawer--is-mobile v-navigation-drawer--open theme--dark*/
</style>