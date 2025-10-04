<template>
  <div>
    <!-- Header/menu uniquement si pas sur Login -->
    <header v-if="!isLoginPage" class="bg-white shadow-md w-full">
      <nav class="container mx-auto flex justify-between items-center py-4 px-6">
        <!-- Logo -->
        <div class="text-2xl font-extrabold text-indigo-600 tracking-wider">
          VitoTemplate Admin
        </div>

        <!-- Navigation -->
        <ul class="flex items-center space-x-8 text-gray-700 font-medium">
          <li>
            <RouterLink
              to="/ViewAdmin"
              class="relative group hover:text-indigo-600 transition"
              active-class="text-indigo-600"
            >
              Home
              <span
                class="absolute left-0 -bottom-1 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
              ></span>
            </RouterLink>
          </li>
          <li>
            <RouterLink
              to="/ViewAdmin/FreeTemplate"
              class="relative group hover:text-indigo-600 transition"
              active-class="text-indigo-600"
            >
              FreeTemplate
              <span
                class="absolute left-0 -bottom-1 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
              ></span>
            </RouterLink>
          </li>
          <li>
            <RouterLink
              to="/ViewAdmin/PaidTemplate"
              class="relative group hover:text-indigo-600 transition"
              active-class="text-indigo-600"
            >
              PaidTemplate
              <span
                class="absolute left-0 -bottom-1 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
              ></span>
            </RouterLink>
          </li>
          <li>
            <RouterLink
              to="/ViewAdmin/Contact"
              class="relative group hover:text-indigo-600 transition"
              active-class="text-indigo-600"
            >
              Contact
              <span
                class="absolute left-0 -bottom-1 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
              ></span>
            </RouterLink>
          </li>
          <li>
            <RouterLink
              to="/ViewAdmin/Admin"
              class="relative group hover:text-indigo-600 transition"
              active-class="text-indigo-600"
            >
              Admin
              <span
                class="absolute left-0 -bottom-1 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
              ></span>
            </RouterLink>
          </li>
        </ul>

        <!-- Partie droite : Switch thème + utilisateur -->
        <div class="flex items-center space-x-4">
          <!-- Switch thème -->
          <v-btn small @click="toggleTheme">
            {{ currentTheme === 'light' ? '🌞' : '🌙' }}
          </v-btn>

          <!-- Utilisateur connecté -->
          <div v-if="User" class="flex items-center space-x-2">
            <img
              :src="User.User.photos || '/default-avatar.png'"
              alt="User Avatar"
              class="w-10 h-10 rounded-full object-cover border border-gray-300"
            />
    
            <span class="font-medium text-gray-700">{{ User.User.name }}</span>
          </div>
        </div>
      </nav>
    </header>

    <RouterView />
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from "vue-router";
import { useUserStore } from "../stores/User";

let User = useUserStore();
</script>

<style scoped>
</style>
