<template>
  <header class="bg-white shadow-md w-full">
    <nav class="container mx-auto flex justify-between items-center py-4 px-6">
      
      <!-- Logo -->
      <div class="text-2xl font-extrabold text-indigo-600 tracking-wider">
        VitoTemplate
      </div>

      <!-- Menu -->
      <ul class="flex items-center space-x-8 text-gray-700 font-medium">
        <li v-for="item in menu" :key="item.name">
          <a
            :href="item.href"
            class="relative group hover:text-indigo-600 transition"
          >
            {{ item.name }}
            <span
              class="absolute left-0 -bottom-1 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"
            ></span>
          </a>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script setup>
const menu = [
  { name: "Accueil", href: "#" },
  { name: "Modèles", href: "#" },
  { name: "Contact", href: "#" },
];
</script>
