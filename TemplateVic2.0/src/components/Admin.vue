<template>
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white p-4 space-y-4">
      <h2 class="text-lg font-bold mb-4">Admin Panel</h2>

      <ul class="space-y-2">
        <li v-for="(tabComponent, tabName) in tabs" :key="tabName">
          <button
            @click="setTab(tabName)"
            class="w-full text-left px-3 py-2 rounded-md hover:bg-gray-700 transition"
            :class="{ 'bg-gray-700': currentTab === tabName }"
          >
            {{ tabName }}
          </button>
        </li>
      </ul>
    </aside>

    <!-- Contenu dynamique -->
    <main class="flex-1 p-6 bg-gray-100">
      <component :is="currentTabComponent" />
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// Importation des composants
import Dashboard from './Dashboard.vue'
import Users from './Users.vue'
import FreeSection from './FreeSection.vue'
import PaidSection from './PaidSection.vue'

// Déclaration des onglets
const tabs = { Dashboard , FreeSection,PaidSection, Users }

// Onglet actuel
const currentTab = ref('Dashboard')

// Calcul du composant actif
const currentTabComponent = computed(() => tabs[currentTab.value])

const setTab = (tabName) => {
  currentTab.value = tabName
}
</script>
