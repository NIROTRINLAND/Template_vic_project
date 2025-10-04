<template>
    <div>
       
 <!-- Header/menu uniquement si pas sur Login -->
<header v-if="!isLoginPage" class="bg-white shadow-md w-full">
  <nav class="container mx-auto flex justify-between items-center py-4 px-6">
    <!-- Logo -->
    <div class="text-2xl font-extrabold text-indigo-600 tracking-wider">
      VitoTemplate
    </div>

    <!-- Navigation -->
    <ul class="flex items-center space-x-8 text-gray-700 font-medium">
      <li>
        <RouterLink
          to="/"
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
          to="/FreeTemplate"
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
          to="/PaidTemplate"
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
          to="/Contact"
          class="relative group hover:text-indigo-600 transition"
          active-class="text-indigo-600"
        >
          Contact
          <span
            class="absolute left-0 -bottom-1 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
          ></span>
        </RouterLink>
      </li>
    </ul>

    <!-- Switch thème -->
    <v-btn small @click="toggleTheme" class="ml-4">
      {{ currentTheme === 'light' ? '🌞' : '🌙' }}
    </v-btn>
  </nav>
</header>



 
  <RouterView/>
    </div>
</template>
<script setup >
  import { RouterLink, RouterView } from 'vue-router'
  import {useUserStore} from '../stores/User'


  let User=useUserStore();
  
</script>


<style scoped>

</style>