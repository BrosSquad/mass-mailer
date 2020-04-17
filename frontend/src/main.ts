import './assets/main.scss';

import Vue from 'vue';
import App from './App.vue';
import router from './router';
import './plugins/vee-validate';
import store from './store';
import vuetify from './plugins/vuetify';

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  // @ts-ignore
  vuetify: vuetify,
  render: h => h(App),
}).$mount('#app');
