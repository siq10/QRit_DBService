import Vue from 'vue'
import App from './App.vue'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import routes from './routes'
import store from './store'
import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader

Vue.use(VueRouter)
Vue.use(Vuetify)
Vue.config.productionTip = false

var router = new VueRouter({
    routes: routes,
    mode: 'history'
})

new Vue({
  router: router,
  store: store,
  render: h => h(App),
}).$mount('#app')
