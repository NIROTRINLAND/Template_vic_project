<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Paid Templates</h1>

    <!-- Bouton afficher/masquer le formulaire -->
    <button
      @click="showForm = !showForm"
      class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
    >
      {{ showForm ? 'Fermer le formulaire' : 'Ajouter un Paid Template' }}
    </button>

    <!-- Formulaire -->
    <div v-if="showForm" class="bg-gray-100 p-4 rounded-lg mb-6 space-y-3">
      <input
        v-model="newTemplate.name"
        type="text"
        placeholder="Nom du template"
        class="border p-2 w-full rounded"
        required
      />

      <textarea
        v-model="newTemplate.description"
        placeholder="Description"
        class="border p-2 w-full rounded"
        required
      ></textarea>

      <input
        v-model.number="newTemplate.price"
        type="number"
        min="0"
        step="0.01"
        placeholder="Prix (€)"
        class="border p-2 w-full rounded"
        required
      />

      <input
        type="file"
        @change="handleFileUpload"
        class="mb-2"
        required
      />

      <button
        @click="addTemplate"
        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
      >
        Enregistrer
      </button>
    </div>

    <!-- Liste des templates avec miniatures -->
    <div class="bg-white shadow rounded-lg p-6">
      <h2 class="text-lg font-semibold mb-4">
        Liste des Paid Templates ({{ templates.length }})
      </h2>

      <div v-if="templates.length" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div
          v-for="template in templates"
          :key="template.id"
          class="border rounded-lg shadow p-3 relative"
       @click="goToViewer(template)"
        >
          <img
            :src="`http://localhost:8000/storage/${template.file_url}`"
            :alt="template.name"
            class="w-full h-40 object-cover mb-2"
          />

          <p class="font-bold">{{ template.name }}</p>
          <p class="text-gray-600 mb-2">{{ template.description }}</p>
          <p class="text-right font-bold text-green-600">{{ formatPrice(template.price) }}</p>

          <p class="text-sm text-gray-500">{{ template.files?.length || 1 }} fichier(s)</p>

          <!-- Bouton Masquer / Afficher -->
          <button
            @click="toggleTemplate(template)"
            class="mt-2 text-sm px-3 py-1 rounded-lg border hover:bg-gray-100"
          >
            {{ template.is_public === 0 ? 'Afficher' : 'Masquer' }}
          </button>

          <!-- Overlay si masqué -->
         
        </div>
      </div>

      <p v-else class="text-gray-500 mt-4">Aucun template ajouté pour l’instant.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { apiClient } from './axios.config.mjs'
import { useRouter } from 'vue-router'
import {useTemplateStore} from '../stores/template'


let TemplateStore=useTemplateStore();
const showForm = ref(false)
const templates = ref([])
const router = useRouter()
const newTemplate = ref({
  name: '',
  description: '',
  price: null,
  files: []
})

// Gestion du fichier
const handleFileUpload = (event) => {
  const file = event.target.files[0]
  newTemplate.value.files = [file]
}

// Ajouter un template
const addTemplate = async () => {
  if (!newTemplate.value.files.length) return

  try {
    const formData = new FormData()
    formData.append("name", newTemplate.value.name)
    formData.append("description", newTemplate.value.description)
    formData.append("price", newTemplate.value.price)
    formData.append("file", newTemplate.value.files[0])

    const res = await apiClient.post("/template", formData)

    fetchTemplates();

    newTemplate.value = { name: '', description: '', price: null, files: [] }
    showForm.value = false
    document.querySelector('input[type="file"]').value = null

  } catch (err) {
    console.error("Erreur upload:", err.response?.data || err.message)
  }
}

 function goToViewer(template){
  TemplateStore.template=template;
 router.push({ 
    name: 'Viewer', 
    params: { name: template.name } 
  })
 }

// Toggle visibilité
const toggleTemplate = async (template) => {
  try {
    // Inverse d'abord localement pour retour immédiat UI
    template.is_public = template.is_public === 0 ? 1 : 0

    // Puis on envoie l'update au serveur
    await apiClient.post("/ModifyVisibility", { template })
    
  } catch (err) {
    console.error("Erreur toggleTemplate:", err)
    // Si erreur, on remet l'état précédent
    template.is_public = template.is_public === 0 ? 1 : 0
  }
}


// Récupérer les templates
const fetchTemplates = async () => {
  try {
    const res = await apiClient.get("/indexPaidTemplateAdmin")
    templates.value = res.data.FreeTemplate.map(t => ({
      id: t.id,
      name: t.name,
      description: t.description,
      price: t.price,
      files: t.files || [],
      file_url: t.screenshot,
      is_public: t.is_public,
      download:t.download // Par défaut visible

    }))
  } catch (err) {
    console.error("Erreur fetchTemplates:", err)
  }
}

onMounted(() => {
  fetchTemplates()
})

// Formatage du prix
const formatPrice = (value) =>
  new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(Number(value || 0))
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
