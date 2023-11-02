import { createApp } from 'vue'
import { createPinia } from 'pinia'
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import App from './App.vue'
import router from './router'
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/reset.css';
import { useRegisterSW } from 'virtual:pwa-register/vue';

library.add(faUserSecret);
useRegisterSW();

const app = createApp(App)

app.use(Antd);
app.use(createPinia())
app.use(router)
app.component('font-awesome-icon', FontAwesomeIcon).mount()

app.mount('#app')
