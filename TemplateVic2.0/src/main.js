import './assets/main.css'
import router from './components/router/index';
import { createApp } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";
import App from './App.vue'

const app = createApp(App)

app.use(createPinia().use(piniaPluginPersistedstate)) // ✅ ajoute Pinia
app.use(router)        // ✅ ajoute le router

app.mount('#app')      // monte l'app

