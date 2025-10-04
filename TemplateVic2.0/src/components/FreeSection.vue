<template>
  <div class="bg-white shadow rounded-lg p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
      <h2 class="text-lg font-semibold mb-2 sm:mb-0">Free Templates</h2>
      <p class="text-3xl font-bold text-blue-600">{{ templates.length }}</p>
    </div>

    <!-- Bouton Ajouter -->
    <button
      @click="showForm = !showForm"
      class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 mb-4"
    >
      {{ showForm ? 'Fermer le formulaire' : 'Ajouter un Free Template' }}
    </button>

    <!-- Formulaire -->
    <div v-if="showForm" class="mt-4 text-left border p-4 rounded-lg bg-gray-50">
      <form @submit.prevent="addTemplate" class="space-y-4">
        <div>
          <label class="block text-sm font-medium">Nom</label>
          <input
            v-model="newTemplate.name"
            type="text"
            class="w-full border rounded-lg px-3 py-2"
            required
          />
        </div>

        <div>
          <label class="block text-sm font-medium">Description</label>
          <textarea
            v-model="newTemplate.description"
            class="w-full border rounded-lg px-3 py-2"
            required
          ></textarea>
        </div>

        <div>
          <label class="block text-sm font-medium">Fichier</label>
          <input
            type="file"
            @change="handleFileUpload"
            class="w-full"
            required
          />
        </div>

        <button
          type="submit"
          class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600"
        >
          Enregistrer
        </button>
      </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <div v-for="template in templates" :key="template.id"    @click="goToViewer(template)" class="border rounded-lg shadow p-3">

        <img
          :src="`http://localhost:8000/storage/${template.file_url}`"
          :alt="template.name"
          class="w-full h-40 object-cover mb-2"
        />
        <p class="font-bold">{{ template.name }}</p>
        <p class="text-sm text-gray-600 mb-2">{{ template.description }}</p>
        <a
     @click="DownoaldTemplate(template)"
          target="_blank"
          class="text-indigo-500 text-sm hover:underline mt-1 block"  
        >
          Télécharger
        </a>
 
        <!-- Bouton Masquer/Afficher -->
        <button
          @click="toggleTemplate(template)"
          class="mt-2 text-sm px-3 py-1 rounded-lg border hover:bg-gray-100"
        >
          {{ template.is_public==0 ? 'Afficher' : 'Masquer' }}
        </button>
      </div>
    </div>
  </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { apiClient } from './axios.config.mjs'
import { useRouter } from 'vue-router'
import {useTemplateStore} from '../stores/template'


let TemplateStore=useTemplateStore();

const router = useRouter()
const showForm = ref(false)
const templates = ref([])

const newTemplate = ref({
  name: '',
  description: '',
  file: null
})

// Upload fichier
const handleFileUpload = (event) => {
  newTemplate.value.file = event.target.files[0]
}
async function DownoaldTemplate(template) {
  const res = await apiClient.post(
    "/Downoald",
    { template: template },
    { responseType: "blob" }   // 👈 obligatoire !
  );

  // Création d’une URL temporaire pour le fichier
  const url = window.URL.createObjectURL(new Blob([res.data]));
  const link = document.createElement("a");
  link.href = url;
  link.setAttribute("download", template.name + ".zip"); // 👈 nom du fichier
  document.body.appendChild(link);
  link.click();
  link.remove();
}

 function goToViewer(template){
  TemplateStore.template=template;
 router.push({ 
    name: 'Viewer', 
    params: { name: template.name } 
  })
 }
// Récupérer les templates depuis l’API
const fetchTemplates = async () => {
  try {
    const res = await apiClient.get("/indexFreeTemplateAdmin")
    templates.value = res.data.FreeTemplate.map(t => ({
      id: t.id,
      name: t.name,
      description: t.description,
      file_url: t.screenshot,
      is_public: t.is_public,
      download:t.download // Par défaut visible
    }))
  } catch (err) {
    console.error("Erreur récupération templates :", err.response?.data || err.message)
  }
}

// Ajouter un template
const addTemplate = async () => {
  if (!newTemplate.value.file) return

  try {
    const formData = new FormData()
    formData.append("name", newTemplate.value.name)
    formData.append("description", newTemplate.value.description)
    formData.append("file", newTemplate.value.file)

    const res = await apiClient.post("/template", formData)

  fetchTemplates();

    newTemplate.value = { name: '', description: '', file: null }
    document.querySelector('input[type="file"]').value = null
    showForm.value = false
  } catch (err) {
    console.error("Erreur upload:", err.response?.data || err.message)
  }
}


const toggleTemplate = async (template) => {
  try {
    console.log(template)
     const res = await apiClient.post("/ModifyVisibility",{template:template})
    // Exemple d'action asynchrone : attendre 1 seconde
   
    // Ici tu peux mettre n'importe quelle logique (API, update etc.)

    // Changer l'état du bouton après exécution
    template.hidden = !template.hidden
    fetchTemplates();
  } catch (err) {
    console.error("Erreur dans toggleTemplate :", err)
  }
}


// Charger les templates au montage
onMounted(() => {
  fetchTemplates()
})
</script>

<style scoped>
button {
  transform: scale(1);
  transition: transform 0.2s;
}
button:hover {
  transform: scale(1.05);
}
</style>
