import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import 'bootstrap/dist/css/bootstrap.css'
import emitter from './eventBus';

createApp(App).mount("#app")
