import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import vuetify from './plugins/vuetify' 
import {http} from './service/config'
import money from "@titou10/v-money";
import 'font-awesome/css/font-awesome.css';

Vue.use(money, { precision: 4 });
Vue.prototype.$http = http
new Vue({
  router,
  vuetify,
  render: (h) => h(App),
}).$mount("#app");
