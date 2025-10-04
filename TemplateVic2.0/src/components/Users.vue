<template>
  <div>
    <h1 class="text-2xl font-bold mb-6">Utilisateurs</h1>

    <!-- Bouton afficher/masquer le formulaire -->
    <button
      @click="showForm = !showForm"
      class="mb-4 px-4 py-2 bg-blue-600 text-white rounded"
    >
      {{ showForm ? 'Fermer' : 'Ajouter un utilisateur' }}
    </button>

    <!-- Formulaire -->
    <div v-if="showForm" class="bg-gray-100 p-4 rounded-lg mb-6">
      <input
        v-model="newUser.firstName"
        type="text"
        placeholder="Prénom"
        class="border p-2 w-full mb-2 rounded"
        required
      />
      <input
        v-model="newUser.lastName"
        type="text"
        placeholder="Nom"
        class="border p-2 w-full mb-2 rounded"
        required
      />
      <input
        v-model="newUser.email"
        type="email"
        placeholder="Email"
        class="border p-2 w-full mb-2 rounded"
        required
      />
      <input
        v-model="newUser.password"
        type="password"
        placeholder="Mot de passe"
        class="border p-2 w-full mb-2 rounded"
        required
      />
      <input
        type="file"
        @change="handlePhoto"
        class="mb-2"
      />
      <button
        @click="addUser"
        class="px-4 py-2 bg-green-600 text-white rounded"
      >
        Ajouter
      </button>
    </div>

    <!-- Liste des utilisateurs -->
    <div class="grid grid-cols-2 gap-4">
      <div
        v-for="(user, index) in users"
        :key="index"
        class="p-4 bg-white shadow rounded-lg flex items-center gap-4"
      >
        <img
          v-if="user.photo"
          :src="user.photo"
          alt="Photo utilisateur"
          class="w-12 h-12 rounded-full object-cover"
        />
        <div>
          <p class="font-bold">{{ user.firstName }} {{ user.lastName }}</p>
          <p class="text-gray-600">{{ user.email }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const showForm = ref(false)

const users = ref([])

const newUser = ref({
  firstName: '',
  lastName: '',
  email: '',
  password: '',
  photo: null
})

// Gestion upload photo
const handlePhoto = (e) => {
  const file = e.target.files[0]
  if (file) {
    newUser.value.photo = URL.createObjectURL(file)
  }
}

// Ajouter un utilisateur
const addUser = () => {
  if (
    !newUser.value.firstName ||
    !newUser.value.lastName ||
    !newUser.value.email ||
    !newUser.value.password
  ) return

  users.value.push({ ...newUser.value })

  // Reset formulaire
  newUser.value = { firstName: '', lastName: '', email: '', password: '', photo: null }
  showForm.value = false
}
</script>
