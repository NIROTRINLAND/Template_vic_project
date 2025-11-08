<!-- Dashboard.vue -->
<template>
  <div class="font-sans text-gray-900 bg-gray-50 min-h-screen p-8">
    <!-- Titre -->
    <h1 class="text-3xl font-extrabold mb-8 text-gray-800">📊 Dashboard</h1>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
      <!-- Free Templates -->
      <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center hover:shadow-xl transition">
        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full mb-4">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2v6a2 2 0 002 2h6a2 2 0 002-2v-6c0-1.1-.9-2-2-2h-6z" />
          </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-600">Free Templates</h2>
        <p class="text-3xl font-bold text-blue-600">{{ stats2.freeTemplates }}</p>
      </div>

      <!-- Paid Templates -->
      <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center hover:shadow-xl transition">
        <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-4">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2v6a2 2 0 002 2h6a2 2 0 002-2v-6c0-1.1-.9-2-2-2h-6z" />
          </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-600">Paid Templates</h2>
        <p class="text-3xl font-bold text-green-600">{{ stats2.paidTemplates }}</p>
      </div>

      <!-- Users -->
      <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center hover:shadow-xl transition">
        <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-full mb-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10-4a4 4 0 11-8 0" />
          </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-600">Users</h2>
        <p class="text-3xl font-bold text-purple-600">{{ stats2.users }}</p>
      </div>
    </div>

    <!-- Détails avec icônes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
      <div class="flex items-center bg-white p-4 rounded-xl shadow hover:shadow-md transition">
        <span class="w-10 h-10 flex items-center justify-center bg-green-100 rounded-full mr-3">
          💰
        </span>
        <p class="text-gray-700">Payants : <span class="font-bold">{{ stats1.paidTemplates }}</span></p>
      </div>

      <div class="flex items-center bg-white p-4 rounded-xl shadow hover:shadow-md transition">
        <span class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full mr-3">
          🎁
        </span>
        <p class="text-gray-700">Gratuits : <span class="font-bold">{{ stats1.freeTemplates }}</span></p>
      </div>

      <div class="flex items-center bg-white p-4 rounded-xl shadow hover:shadow-md transition">
        <span class="w-10 h-10 flex items-center justify-center bg-purple-100 rounded-full mr-3">
          👤
        </span>
        <p class="text-gray-700">Utilisateurs : <span class="font-bold">{{ stats1.users }}</span></p>
      </div>
    </div>

    <!-- Tableau -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
      <table class="w-full text-left border-collapse">
        <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
          <tr>
            <th class="px-6 py-3">Template</th>
            <th class="px-6 py-3">Utilisateur</th>
            <th class="px-6 py-3">Heure de création</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-gray-700">
          <tr v-for="users in stats1.allTemplate" :key="users.id" class="hover:bg-gray-50">
            <td class="px-6 py-3 font-medium">{{ users.name }}</td>
            <td class="px-6 py-3">{{ users.creator_name }}</td>
            <td class="px-6 py-3">{{ users.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import { apiClient } from './axios.config.mjs'
import { reactive } from 'vue'
let  stats1=ref({
    freeTemplates: "",
  paidTemplates: "",
  users: "",
  allTemplate:""
})
let stats2=ref(
  {
  
  freeTemplates: 120,
  paidTemplates: 45,
  users: 350
 
  }
)
const stats = reactive({
  freeTemplates: 120,
  paidTemplates: 45,
  users: 350
})

async function Allstats(){
  try {
    const res = await apiClient.get("/Stat")
   const res1 = await apiClient.get("/TemplateStat")

    stats1.value.freeTemplates=res.data.FreeTemplateByDay
    stats1.value.paidTemplates=res.data.PaidTemplateByDay
     stats1.value.users=res.data.uniqueCreatorsToday
     stats1.value.allTemplate=res.data.template_users_curr

  stats2.value.freeTemplates=res1.data.FreeTemplate
    stats2.value.paidTemplates=res1.data.PaidTemplate
     stats2.value.users=res1.data.user
 
  } catch (error) {
    
  }
}

onMounted(() => {
 Allstats()

})
</script>
