<template>
  <section class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
      <!-- Contact info -->
      <h1 class="text-3xl font-extrabold text-indigo-600">Contact VitoTemplate</h1>
      <p class="mt-4 text-gray-700">
        Vous pouvez envoyer un email à
        <span class="font-semibold">contact [at] VitoTemplate.com</span>
        pour toute question. Vous pouvez également nous écrire sur notre
        <a href="#" class="text-indigo-600 underline">page Facebook</a>
        pour obtenir une réponse rapide.
      </p>

      <!-- Formulaire de contact -->
      <section class="mt-6 bg-white p-6 rounded-xl shadow">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Envoyez-nous un message</h2>

        <form @submit.prevent="handleSubmit" class="space-y-4">
          <div>
            <label class="block text-gray-700 font-medium mb-1" for="name">Nom</label>
            <input v-model="form.name" type="text" id="name" required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1" for="email">Email</label>
            <input v-model="form.email" type="email" id="email" required
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
          </div>

          <div>
            <label class="block text-gray-700 font-medium mb-1" for="message">Message</label>
            <textarea v-model="form.message" id="message" required rows="5"
              class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
          </div>

          <button type="submit"
            class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">Envoyer</button>

          <p v-if="successMessage" class="text-green-600 font-medium mt-2">{{ successMessage }}</p>
          <p v-if="errorMessage" class="text-red-600 font-medium mt-2">{{ errorMessage }}</p>
        </form>
      </section>

      <hr class="my-10" />

      <!-- FAQ -->
      <h2 class="text-2xl font-bold text-gray-900">Questions fréquentes sur nos modèles gratuits</h2>
      <div class="mt-6 space-y-6">
        <details v-for="(item, idx) in faqs" :key="idx" class="group rounded-xl bg-white p-5 shadow">
          <summary class="cursor-pointer select-none text-base font-semibold text-gray-900">
            {{ item.q }}
          </summary>
          <p class="mt-3 text-gray-700" v-html="item.a" />
        </details>
      </div>

      <!-- Footer / Copyright -->
      <footer class="mt-12 text-sm text-gray-600">
        <p>
          Copyright © 2024 Modèles HTML gratuits par VitoTemplate - 
          <a href="#" class="text-indigo-600 hover:underline">À propos</a> - 
          <a href="#" class="text-indigo-600 hover:underline">Politique de confidentialité</a> - 
          <a href="#" class="text-indigo-600 hover:underline">Plan du site</a>
        </p>
      </footer>
    </div>
  </section>
</template>

<script setup>
import { reactive, ref, computed } from 'vue'
import { apiClient } from './axios.config.mjs'

// Partages (tu peux activer si besoin)
const shares = reactive({
  total: 836,
  facebook: 357,
  twitter: 64,
  pinterest: 53,
  email: 86
})
const totalShares = computed(() => shares.total)

// FAQ
const faqs = [
  { q: 'Comment créer un formulaire de contact HTML pour envoyer un email ?', a: 'Vous pouvez essayer ce <a href="#" class="text-indigo-600 underline">script de formulaire de contact</a>.' },
  { q: 'Puis-je soutenir le site VitoTemplate ?', a: 'Veuillez faire un don PayPal à <span class="font-medium">contact [at] VitoTemplate.com</span> et vous pouvez aussi parler de VitoTemplate à vos amis. Merci.' },
  { q: 'Les modèles sont-ils gratuits pour tout type d’utilisation ?', a: 'Oui, ils sont totalement gratuits pour vos sites personnels, éducatifs et commerciaux.' },
  { q: 'Puis-je modifier un modèle pour créer un site client ?', a: 'Oui, vous pouvez modifier et utiliser nos modèles et facturer vos services à vos clients.' },
  { q: 'Puis-je supprimer les liens de crédit des modèles ?', a: 'Oui, vous pouvez supprimer les liens de crédit.' },
  { q: 'Puis-je redistribuer les modèles sur mon site ?', a: 'Non, merci de ne pas redistribuer nos modèles sur un autre site de modèles. Ce n’est pas autorisé. Veuillez lire la page À propos.' }
]

// Formulaire
const form = reactive({ name: '', email: '', message: '' })
const successMessage = ref('')
const errorMessage = ref('')

const handleSubmit = async () => {
  successMessage.value = ""
  errorMessage.value = ""

  try {
    const res = await apiClient.post("/ContactCreator", {
      name: form.name,
      email: form.email,
      message: form.message,
    })

    if (res.status === 200) {
      successMessage.value = "Votre message a été envoyé avec succès ✅"
      // Réinitialiser le formulaire
      form.name = ""
      form.email = ""
      form.message = ""
    } else {
      errorMessage.value = "Une erreur est survenue. Veuillez réessayer."
    }
  } catch (err) {
    console.error(err)
    errorMessage.value =
      err.response?.data?.message || "Impossible d'envoyer le message ❌"
  }
}
</script>

<style scoped>
.container { max-width: 64rem; }
</style>
