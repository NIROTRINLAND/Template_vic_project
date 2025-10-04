<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-indigo-50 p-4">
    <div class="w-full max-w-2xl flex flex-col md:flex-row rounded-xl overflow-hidden shadow-2xl form-container">
      
      <!-- Section gauche -->
      <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-indigo-600 to-purple-700 text-white p-12 flex-col justify-between animate-fadeIn">
        <div class="text-center space-y-4">
          <h2 class="text-3xl font-semibold">Welcome Back</h2>
          <p class="text-lg opacity-90">
            "Success is the sum of small efforts, repeated day in and day out."
          </p>
        </div>
        <div class="opacity-70 flex justify-center mt-8">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15l8-8m0 0l-8-8m8 8H4" />
          </svg>
        </div>
      </div>

      <!-- Section droite -->
      <div class="w-full md:w-1/2 bg-white p-10 flex flex-col justify-center">
        <div class="mb-8 text-center">
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Page de connexion</h1>
          <p class="text-gray-500">Entrer vos données pour vous connecter</p>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-6">

          <!-- Email -->
          <div class="relative">
            <input
              v-model="form.email"
              type="email"
              id="email"
              placeholder=" "
              class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
              required
            />
            <label
              for="email"
              class="absolute left-4 top-3 text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-indigo-600 peer-focus:text-sm"
            >
              Email
            </label>
            <p v-if="errors.email" class="mt-1 text-sm text-red-500">{{ errors.email }}</p>
          </div>

          <!-- Password -->
          <div class="relative">
            <input
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              id="password"
              placeholder=" "
              class="peer w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all"
              required
            />
            <label
              for="password"
              class="absolute left-4 top-3 text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-indigo-600 peer-focus:text-sm"
            >
              Password
            </label>
            <button
              type="button"
              @click="togglePasswordVisibility"
              aria-label="Toggle password visibility"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7C7.523 19 3.732 16.057 2.458 12z"
                />
              </svg>
            </button>
            <p v-if="errors.password" class="mt-1 text-sm text-red-500">{{ errors.password }}</p>
          </div>

          <!-- Options -->
          <div class="flex items-center justify-between">
            <label class="flex items-center space-x-2">
              <input type="checkbox" v-model="form.rememberMe" class="h-4 w-4 text-indigo-600 rounded focus:ring-indigo-500" />
              <span class="text-sm text-gray-700">Remember me</span>
            </label>
            <a href="#" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
          </div>

          <!-- Submit -->
          <button
            type="submit"
            :disabled="isSubmitting"
            class="w-full py-3 px-4 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center transform active:scale-95"
          >
            <span v-if="!isSubmitting">Sign In</span>
            <span v-else class="flex items-center">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Processing...
            </span>
          </button>

        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import {apiClient} from './axios.config.mjs';
import { useRouter } from 'vue-router';
const form = ref({
  email: '',
  password: '',
  rememberMe: false,
});
const router = useRouter();
const errors = ref({
  email: '',
  password: '',
});

const showPassword = ref(false);
const isSubmitting = ref(false);

const togglePasswordVisibility = () => showPassword.value = !showPassword.value;

const validateForm = () => {
  let isValid = true;
  errors.value = { email: '', password: '' };

  if (!form.value.email) {
    errors.value.email = 'Email is required.';
    isValid = false;
  } else if (!/\S+@\S+\.\S+/.test(form.value.email)) {
    errors.value.email = 'Please enter a valid email.';
    isValid = false;
  }

  if (!form.value.password) {
    errors.value.password = 'Password is required.';
    isValid = false;
  } else if (form.value.password.length < 6) {
    errors.value.password = 'Password must be at least 6 characters.';
    isValid = false;
  }

  return isValid;
};

const handleSubmit = async () => {
  if (!validateForm()) return;

  isSubmitting.value = true;
  errors.value = { email: '', password: '', general: '' };

  try {
    const res = await apiClient.post('/login', {
      email: form.value.email,
      password: form.value.password
    });

    // ✅ Login réussi
    localStorage.setItem('token', res.data.data.token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${res.data.data.token}`;

    // ✅ Redirection vers ViewAdmin/Home
    router.push('/ViewAdmin');

  } catch (err) {
    // ✅ Gestion des erreurs
    if (err.response) {
      // L’API a répondu avec un code d’erreur
      switch(err.response.status) {
        case 401:
          errors.value.general = 'Email ou mot de passe incorrect';
          break;
        case 422:
          // Validation côté serveur
          errors.value.email = err.response.data.errors?.email?.[0] || '';
          errors.value.password = err.response.data.errors?.password?.[0] || '';
          break;
        default:
          errors.value.general = 'Erreur serveur, réessayez plus tard';
      }
    } else if (err.request) {
      // Pas de réponse du serveur
      errors.value.general = 'Impossible de contacter le serveur';
    } else {
      // Autres erreurs
      errors.value.general = 'Une erreur est survenue';
    }
  } finally {
    isSubmitting.value = false; // bouton réactivé
  }
};
</script>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.form-container { animation: fadeIn 0.5s ease-out; }
</style>
