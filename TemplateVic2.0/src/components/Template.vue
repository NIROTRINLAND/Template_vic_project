<template>
  <div class="min-h-screen bg-white text-gray-900">
  
    <!-- Navbar fixe / sticky -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
      <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Minimal White</h1>
        <button class="md:hidden">
          <!-- Icône hamburger -->
          <span class="block w-6 h-0.5 bg-black mb-1"></span>
          <span class="block w-6 h-0.5 bg-black mb-1"></span>
          <span class="block w-6 h-0.5 bg-black"></span>
        </button>
        <ul class="hidden md:flex gap-8 text-sm">
          <li><a href="#" class="hover:underline">Home</a></li>
          <li><a href="#" class="hover:underline">Templates</a></li>
          <li><a href="#" class="hover:underline">Contact</a></li>
        </ul>
      </nav>
    </header>
  
    <!-- Section intro -->
    <section class="container mx-auto px-6 py-16 text-center">
      <h2 class="text-3xl md:text-4xl font-extrabold">Minimal White Template</h2>
      <p class="mt-4 text-gray-700 max-w-2xl mx-auto leading-relaxed">
        A sleek one-page template with a classic black-and-white aesthetic, clean typography and modern geometric layout.
      </p>

      <!-- Image screenshot -->
      <div class="mt-10">
        <img 
          src="https://www.tooplate.com/screenshots-720/template-2141-minimal-white.jpg" 
          alt="Minimal White Screenshot" 
          class="w-full rounded-xl shadow-lg border mx-auto max-h-[500px] object-cover"
        />
      </div>
    </section>
   <section class=" px-6 py-12 text-gray-800">
    <!-- Titre -->
    <h1 class="text-3xl font-bold mb-6">Template Minimal White</h1>

    <!-- Description -->
    <p class="mb-4">
      C’est un template élégant et moderne d’une seule page, conçu avec une esthétique minimaliste
      et soignée. Il combine un schéma classique noir et blanc avec une typographie claire
      et une précision géométrique pour offrir une expérience utilisateur sophistiquée et élégante.
    </p>

    <p class="mb-4">
      Ce template est parfait pour les agences créatives, studios de design, freelances ou toute personne
      souhaitant présenter son travail dans un style raffiné et contemporain.
    </p>

    <p class="mb-4">
      Ses principales caractéristiques incluent des mises en page créatives et engageantes,
      comme une grille asymétrique pour les services, des animations discrètes au défilement,
      et des effets interactifs au survol qui enrichissent l’expérience utilisateur.
    </p>

    <p class="mb-4">
      Construit avec un code HTML et CSS propre, ce template est totalement responsive,
      garantissant un rendu harmonieux sur tous les appareils, et dispose d’une barre
      de navigation fixe qui se transforme en menu hamburger sur les petits écrans.
    </p>

    <p class="mb-6">
      Vous êtes autorisé à utiliser ce template pour vos projets commerciaux.
      Vous pouvez lire davantage à propos des droits d’utilisation du template Minimal White.
    </p>

    <!-- Infos -->
    <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600">
      <span><strong>Créé le :</strong> 10 août 2025</span>
      <span><strong>Vues :</strong> 2 153</span>
      <span><strong>Téléchargements :</strong> 294</span>
    </div>
    <div class="flex flex-wrap justify-center gap-4">
        <a 
          href="#" 
          class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition"
        >
          Download
        </a>
        <a 
          href="#" 
          class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg shadow hover:bg-gray-300 transition"
        >
          Live View
        </a>
        <a 
          href="#" 
          class="px-6 py-3 bg-gray-800 text-white rounded-lg shadow hover:bg-black transition"
        >
          Full Screenshot
        </a>
      </div>
  </section>

  
    <!-- Footer simple -->
    <footer class="bg-gray-50 py-8 mt-12">
      <div class="container mx-auto text-center text-sm text-gray-500">
        © 2025 Free HTML Templates by Tooplate — About — Privacy Policy — Sitemap
      </div>
    </footer>
  </div>
</template>

<script setup>
 
</script>

<style scoped>
/* Tu peux ajouter une petite animation si tu veux */
img {
  transition: transform 0.4s ease;
}
img:hover {
  transform: scale(1.02);
}
</style>
