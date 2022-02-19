import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';
import Vant, { Toast } from 'vant';
import { InertiaProgress } from '@inertiajs/progress';
import 'vant/lib/index.css';

Vue.prototype.$route = route;
Vue.use(Toast);
Vue.prototype.$toast = function ($message) {
  Toast({
    message: $message,
    position: 'bottom',
  });
};

Vue.use(Vant);
InertiaProgress.init(); 

  createInertiaApp({
    resolve: name => require(`./src/${name}`),
    setup({ el, App, props }) {
      new Vue({
        render: h => h(App, props),
      }).$mount(el)
    },
  })
  



