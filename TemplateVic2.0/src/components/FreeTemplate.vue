<template>
  <section class="p-8 lg:p-16 bg-gray-50">
    <!-- Titre -->
    <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-600 mb-6">
      Free HTML Templates
    </h1>
  
    <!-- Description -->
    <p class="text-gray-700 text-lg max-w-2xl mb-10">
      Tooplate features
      <span class="font-semibold">free responsive & mobile ready HTML templates</span>
      for you to download instantly.
      Feel free to edit any template in your HTML code editor and use it for
      <span class="font-semibold">commercial or personal purposes</span>.
    </p>
  
  
  
    <!-- Grille des templates -->
    <div class="flex flex-wrap gap-4 justify-start">
      <div v-for="(template, index) in templates" :key="index" @click="goToViewer(template)"
        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
  
        <img :src="`http://localhost:8000/storage/${template.file_url}`" alt="" class="w-full h-40 object-cover">
  
        <div class="p-6">
          <h2 class="text-xl font-semibold text-gray-800">{{ template.name }}</h2>
          <p class="text-gray-600 text-sm mb-4">{{ template.description }}</p>
          <div class="flex justify-between items-center">
            <span class="text-indigo-600 font-bold text-lg">0£</span>
  
          </div>
        </div>
      </div>
    </div>
  
  
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { apiClient } from './axios.config.mjs'
import { useRouter } from 'vue-router'
import { useTemplateStore } from '../stores/template'

const router = useRouter()
let TemplateStore = useTemplateStore();

 function goToViewer(template){
  TemplateStore.template=template;
 router.push({ 
    name: 'Viewer', 
    params: { name: template.name } 
  })
 }

const templates = ref([])

// Fonction pour récupérer les templates depuis le backend
const fetchTemplates = async () => {
  try {
    const res = await apiClient.get("/Freetemplate") // GET vers ton endpoint
    console.log("Réponse serveur :", res.data)

    // Remplir la liste de templates avec les données du backend
    templates.value = res.data.FreeTemplate.map(t => ({
      name: t.name || t.title,
      description: t.description || '',
      file_url: t.screenshot,
      download: t.download || '#'
    }))
  } catch (err) {
    console.error("Erreur récupération templates :", err.response?.data || err.message)
  }
}

// Lancer la requête dès que le composant est monté
onMounted(() => {
  fetchTemplates()
})
</script>

<style scoped>
/* Animation légère pour les boutons */
button {
  transform: scale(1);
  transition: transform 0.2s;
}

button:hover {
  transform: scale(1.05);
}
</style>
