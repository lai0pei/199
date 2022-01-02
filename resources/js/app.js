import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';
import Toast from 'vue-easy-toast';

Vue.prototype.$route = route;
Vue.use(Toast);
Vue.prototype.$toast = function ($message) {
  Vue.toast($message, {
    horizontalPosition: 'center',
    verticalPosition: 'center',
    duration: 3000,
    mode: 'queue',
    transition: 'my-transition'

  })
};


createInertiaApp({
  resolve: name => require(`./src/${name}`),
  setup({ el, App, props }) {
    new Vue({
      render: h => h(App, props),
    }).$mount(el)
  },
})

