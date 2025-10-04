<template>
  <div class="font-sans text-gray-900 bg-gray-50">

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 text-white py-40 text-center overflow-hidden">
      <div class="container mx-auto px-6 relative z-10">
        <h1 class="text-5xl md:text-7xl font-extrabold mb-4 drop-shadow-lg">{{ template.name }}</h1>
        <p class="text-lg md:text-2xl text-white/90 max-w-2xl mx-auto">
          Téléchargez des templates modernes et élégants pour vos projets.
        </p>
      </div>
      <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
      <div class="absolute -top-32 -right-32 w-[500px] h-[500px] bg-white/10 rounded-full blur-3xl"></div>
    </section>

    <!-- Image Section -->
    <section class="py-20 flex justify-center">
      <div class="relative max-w-4xl w-full bg-white shadow-2xl rounded-3xl overflow-hidden group">
        <img :src="`http://localhost:8000/storage/${template.file_url}`" alt="Template Image"
             class="w-full  object-cover transition-transform duration-700 group-hover:scale-105" />
        <div v-if="template.price"
             class="absolute top-5 right-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold text-lg rounded-full w-16 h-16 flex items-center justify-center shadow-xl">
          {{ template.price }}$
        </div>
      </div>
    </section>

    <!-- Description Section -->
    <section class="py-20 bg-white text-center px-6 md:px-20">
      <h2 class="text-4xl md:text-5xl font-bold mb-6 text-gray-800">{{ template.name }}</h2>
      <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">{{ template.description }}</p>
      <p class="mt-4 text-gray-500 text-sm">📥 Déjà téléchargé <span class="font-semibold">{{ template.download }}</span> fois</p>

      <div class="flex flex-col sm:flex-row justify-center gap-6 mt-10">
        <button @click="goToPreviewer"
                class="px-8 py-3 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold shadow-lg hover:shadow-xl hover:opacity-90 transition">
          👁️ Preview
        </button>
        <button @click="DownoaldTemplate(template)"
                class="px-8 py-3 rounded-full border-2 border-indigo-600 text-indigo-600 font-semibold bg-white shadow-md hover:bg-indigo-600 hover:text-white transition">
          ⬇️ Download
        </button>
      </div>
    </section>

    <!-- Rating Section -->
    <section class="py-10 bg-gray-50 text-center">
      <h3 class="text-2xl font-bold mb-4 text-gray-800">Donnez votre note</h3>
      <div class="flex justify-center gap-2 mb-4">
        <button v-for="n in 5" :key="n"
                :class="['text-4xl', n <= hover || n <= rating ? 'text-yellow-400' : 'text-gray-300']"
                @mouseenter="hover = n" @mouseleave="hover = 0" @click="setRating(n)"
                :title="n + ' étoile(s)'">★</button>
      </div>
      <button v-if="CacheEnvoye"
              class="px-6 py-2 rounded-full bg-indigo-600 text-white font-semibold shadow-md hover:bg-indigo-700 transition"
              :disabled="loading || rating === 0" @click="submitRating">
        {{ loading ? 'Enregistrement...' : 'Envoyer la note' }}
      </button>
      <p v-if="message" class="text-green-600 mt-2">{{ message }}</p>
      <p v-if="error" class="text-red-600 mt-2">{{ error }}</p>
      <div class="mt-4 text-gray-700">
        Moyenne actuelle : <strong>{{ notation }}</strong> / 5
      </div>
    </section>

    <!-- Creator Section -->
    <section class="py-10 bg-white text-center px-6 md:px-20">
      <h3 class="text-2xl font-bold mb-4 text-gray-800">Créé par {{ creator.name }}</h3>
      <div class="flex justify-center">
        <img :src="creator.photos" alt="Créateur" class="w-40 h-40 rounded-full object-cover shadow-lg transition-transform duration-500 hover:scale-105" />
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 text-center">
      <p class="text-gray-400 text-sm">&copy; 2025 <span class="font-semibold">DigitalAgency</span>. Tous droits réservés.</p>
    </footer>

  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import { useTemplateStore } from '../stores/template'
import { apiClient } from './axios.config.mjs'
import { useRouter } from 'vue-router'

const TemplateStore = useTemplateStore()
const template = TemplateStore.template
const router = useRouter()

// Rating Variables
const rating = ref(0)
const hover = ref(0)
const loading = ref(false)
let CacheEnvoye=ref(true)
let creator=ref('')
const message = ref('')
const error = ref('')
const moyenne = ref(template.avg_rating || null)
const count = ref(template.count_rating || 0)
let notation=ref('')
function setRating(n) {
  rating.value = n
  message.value = ''
  error.value = ''
}


async function ShowRating(){

console.log(template)

     const res = await apiClient.post(`/ShowRating`, {template:template})
    notation.value=res.data.moyenne
    console.log(res)
}




async function submitRating() {
  if (rating.value === 0) return
  loading.value = true
  message.value = ''
  error.value = ''
console.log(rating.value)
  try {
    const res = await apiClient.post(`/Rating`, { rating: rating.value ,template:template})

    if (res.data.moyenne !== undefined) moyenne.value = res.data.moyenne
    if (res.data.count !== undefined) count.value = res.data.count

    if (!res.data.moyenne) {
      moyenne.value = ((moyenne.value || 0) * count.value + rating.value) / (count.value + 1)
      count.value += 1
    }

    message.value = 'Merci pour votre note !'
 
  } catch (err) {
    error.value = err.response?.data?.message || 'Erreur lors de l’enregistrement.'
  } finally {
    loading.value = false
  }
  CacheEnvoye.value=false;
  ShowRating();
}

async function DownoaldTemplate(template) {
  const res = await apiClient.post('/Downoald', { template: template }, { responseType: 'blob' })
  const url = window.URL.createObjectURL(new Blob([res.data]))
  const link = document.createElement('a')
  link.href = url
  link.setAttribute('download', template.name + '.zip')
  document.body.appendChild(link)
  link.click()
  link.remove()
}

function goToPreviewer() {
  router.push({ name: 'Preview', params: { name: template.name } })
}

onMounted(async () => {
  ShowRating()

  try {
    const res = await apiClient.post(
      '/ShowCreator',
      { template: template },
      
    )
    console.log('Template:', TemplateStore.template)
    console.log('Réponse blob:', res)
    creator.value=res.data.creator;
  } catch (err) {
    console.error('Erreur ShowCreator:', err)
  }
})
</script>

<style scoped>
.star { cursor: pointer; transition: transform .1s ease }
.star:hover { transform: scale(1.2) }
</style>