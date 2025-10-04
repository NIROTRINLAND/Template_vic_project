<template>
  <div class="bg-gray-50 min-h-screen">
    <!-- Carousel -->
    <Carousel />
  
    <!-- Section principale -->
    <section class="mx-auto p-8 lg:p-16 justify-between gap-16">
      <!-- Texte -->
      <div class="lg:w-1/2">
        <h1 class="text-4xl lg:text-5xl font-extrabold text-indigo-600 mb-6 leading-tight">
          60+ modèles de sites HTML gratuits
        </h1>
        <p class="text-gray-700 mb-4 text-lg">
          VitoTemplate propose <span class="font-semibold">plus de 60 modèles de sites HTML gratuits</span>, adaptés aux
          mobiles et responsives, utilisant les bibliothèques CSS et JS Bootstrap les plus populaires.
        </p>
        <p class="text-gray-700 mb-6 text-lg">
          Tous nos modèles HTML sont <span class="font-semibold">faciles à modifier</span> et à appliquer à votre site
          web. Vous pouvez utiliser n’importe quel éditeur de code HTML pour personnaliser nos templates.
        </p>
        <p class="text-gray-700 mb-6 text-lg">
          Si vous avez une question ou un commentaire, n’hésitez pas à
          <a href="#" class="text-indigo-600 underline hover:text-indigo-800 transition">nous contacter</a>.
          Merci de visiter VitoTemplate.
        </p>
      </div>
    </section>
  
  </div>
  <section class="p-6 bg-gray-50">
    <h1 class="text-2xl sm:text-3xl font-bold text-indigo-600 mb-4">Derniers templates</h1>
  
    <!-- Flex wrap pour les cartes -->
    <div class="flex flex-wrap gap-4 justify-start">
      <div v-for="template in templates1" :key="template.id" @click="goToViewer(template)"
        class="flex-shrink-0 w-80 sm:w-64 md:w-96 lg:w-112 bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl hover:scale-105 transform transition-transform duration-300 cursor-pointer">
        <!-- Image carrée -->
        <div class="w-full aspect-square overflow-hidden">
          <img :src="`http://localhost:8000/storage/${template.file_url}`" :alt="template.name"
            class="w-full h-full object-cover">
        </div>
        <div class="p-2">
          <h2 class="text-sm font-semibold text-indigo-600 mb-1 truncate">{{ template.name }}</h2>
          <p class="text-gray-600 text-xs line-clamp-2">{{ template.description }}</p>
        </div>
      </div>
    </div>
  </section>
  
  <CarouselTempl />
  
  <section class="p-6 bg-gray-50">
    <h1 class="text-2xl sm:text-3xl font-bold text-indigo-600 mb-6">Templates HTML Mis en Avant</h1>
  
    <!-- Flex wrap pour les cartes -->
   <div class="flex flex-wrap gap-4 justify-start">
      <div v-for="template in featuredTemplates" :key="template.id" @click="goToViewer(template)"
        class="flex-shrink-0 w-80 sm:w-64 md:w-96 lg:w-112 bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl hover:scale-105 transform transition-transform duration-300 cursor-pointer">
        <!-- Image carrée -->
        <div class="w-full aspect-square overflow-hidden">
          <img :src="`http://localhost:8000/storage/${template.file_url}`" :alt="template.name"
            class="w-full h-full object-cover">
        </div>
        <div class="p-2">
          <h2 class="text-sm font-semibold text-indigo-600 mb-1 truncate">{{ template.name }}</h2>
          <p class="text-gray-600 text-xs line-clamp-2">{{ template.description }}</p>
        </div>
      </div>
    </div>
  </section>
  
  <section class=" p-6 bg-white rounded-lg shadow-md mt-10">
    <h1 class="text-3xl font-bold text-indigo-600 mb-4">
      À propos du site VitoTemplate
    </h1>
    <p class="text-gray-700 mb-4 text-lg">
      VitoTemplate vous propose une variété de <span class="font-semibold">templates HTML gratuits</span>
      pour vos sites d'entreprise, pages marketing, galeries d'images et portfolios personnels.
    </p>
    <p class="text-gray-700 mb-4 text-lg">
      VitoTemplate utilise un <span class="font-semibold">kit UI Bootstrap open-source</span>
      pour les dernières mises en page HTML et CSS.
    </p>
    <p class="text-gray-700 text-lg">
      Vous pouvez télécharger instantanément n'importe quel template <span class="font-semibold">gratuitement</span>.
      Aucun login ni inscription n'est requis pour utiliser nos templates.
    </p>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Carousel from './Carousel.vue'
import CarouselTempl from './CarouselTemplate.vue'
import { apiClient } from './axios.config.mjs'
import { useTemplateStore } from '../stores/template'
import { useRouter } from 'vue-router'


let TemplateStore = useTemplateStore();

const router = useRouter()
function goToViewer(template) {
  TemplateStore.template = template;
  router.push({
    name: 'Viewer',
    params: { name: template.name }
  })
}

const templates1 = ref([])


// Récupérer les templates depuis l’API
const fetchTemplates = async () => {
  try {
    const res = await apiClient.get("/indexFreeTemplateAdminHome")
    templates1.value = res.data.FreeTemplate.map(t => ({
      id: t.id,
      name: t.name,
      description: t.description,
      file_url: t.screenshot,
      is_public: t.is_public,// Par défaut visible
      download: t.download // Par défaut visible

    }))


    const res2 = await apiClient.get("/indexFreeTemplateMosDownoald")
    featuredTemplates.value = res2.data.FreeTemplate.map(t => ({
      id: t.id,
      name: t.name,
      description: t.description,
      file_url: t.screenshot,
      is_public: t.is_public,// Par défaut visible
      download: t.download // Par défaut visible

    }))
  } catch (err) {
    console.error("Erreur récupération templates :", err.response?.data || err.message)
  }
}
let featuredTemplates = ref([
  { name: "PortfolioX", screenshot: "https://picsum.photos/seed/51/400/400", description: "Template élégant pour portfolio personnel, mettant en valeur vos projets avec une mise en page moderne." },
  { name: "BusinessPro", screenshot: "https://picsum.photos/seed/52/400/400", description: "Template professionnel pour entreprises, avec des sections dédiées aux services, témoignages et équipe." },
  { name: "EcomShop", screenshot: "https://picsum.photos/seed/53/400/400", description: "Template e-commerce responsive, idéal pour présenter vos produits avec une interface utilisateur intuitive." },
  { name: "LandingPagePro", screenshot: "https://picsum.photos/seed/54/400/400", description: "Template de landing page optimisé pour la conversion, avec des appels à l'action clairs et un design épuré." },
  { name: "BlogMaster", screenshot: "https://picsum.photos/seed/55/400/400", description: "Template de blog élégant, avec une mise en page responsive et des sections pour articles et sidebar." },
  { name: "Cleanfolio", screenshot: "https://picsum.photos/seed/56/400/400", description: "Template minimaliste pour portfolio, mettant en avant vos projets avec une esthétique épurée." },
  { name: "TravelMate", screenshot: "https://picsum.photos/seed/62/400/400", description: "Template pour les sites de voyage, avec des sections pour les destinations, les offres et les témoignages." },
  { name: "Fashionista", screenshot: "https://picsum.photos/seed/63/400/400", description: "Template pour les sites de mode, avec des sections pour les collections, les tendances et les contacts." },
  { name: "Foodie", screenshot: "https://picsum.photos/seed/64/400/400", description: "Template pour les blogs culinaires, avec des sections pour les recettes, les critiques et les contacts." },
  { name: "Photographer", screenshot: "https://picsum.photos/seed/65/400/400", description: "Template pour les portfolios de photographes, mettant en valeur les galeries d'images avec une mise en page élégante." },
  { name: "StartupHub", screenshot: "https://picsum.photos/seed/66/400/400", description: "Template pour les startups, avec des sections pour les services, les témoignages et les contacts." },
  { name: "ConsultingPro", screenshot: "https://picsum.photos/seed/67/400/400", description: "Template pour les sites de conseil, avec des sections pour les services, les témoignages et les contacts." },
  { name: "WeddingPlanner", screenshot: "https://picsum.photos/seed/68/400/400", description: "Template pour la planification de mariages, avec des sections pour les services, les témoignages et les contacts." },
  { name: "FitnessPro", screenshot: "https://picsum.photos/seed/69/400/400", description: "Template pour les sites de fitness, avec des sections pour les programmes, les témoignages et les contacts." },
  { name: "RealEstatePro", screenshot: "https://picsum.photos/seed/70/400/400", description: "Template pour les sites immobiliers, avec des sections pour les propriétés, les témoignages et les contacts." },
  { name: "MarketingPro", screenshot: "https://picsum.photos/seed/71/400/400", description: "Template pour pages marketing et produits, avec design moderne et responsive." },
  { name: "BusinessElite", screenshot: "https://picsum.photos/seed/72/400/400", description: "Template pour sites d’entreprises et services, avec sections équipe, services et contact." },
  { name: "CreativeMind", screenshot: "https://picsum.photos/seed/73/400/400", description: "Template pour agences créatives et portfolios, mettant en avant vos projets." },
  { name: "DesignHub", screenshot: "https://picsum.photos/seed/74/400/400", description: "Portfolio moderne avec galerie intégrée et sections de présentation." },
  { name: "EcoShop", screenshot: "https://picsum.photos/seed/93/400/400", description: "Template pour boutique écologique, produits durables et sections promotion." },
  { name: "FoodMaster", screenshot: "https://picsum.photos/seed/94/400/400", description: "Template pour restaurants et recettes, galerie et sections avis clients." },
  { name: "TravelElite", screenshot: "https://picsum.photos/seed/95/400/400", description: "Template pour agences de voyage premium, sections destinations et services." },
  { name: "EventX", screenshot: "https://picsum.photos/seed/96/400/400", description: "Template pour événements, conférences et ateliers, responsive et moderne." },
  { name: "PhotoPro", screenshot: "https://picsum.photos/seed/97/400/400", description: "Portfolio pour photographes, galeries et sections contact." },
  { name: "LandingElite", screenshot: "https://picsum.photos/seed/98/400/400", description: "Page de destination moderne, optimisée pour les conversions et responsive." },
  { name: "AgencyX", screenshot: "https://picsum.photos/seed/99/400/400", description: "Template pour agences digitales, sections portfolio et services." },
  { name: "BlogX", screenshot: "https://picsum.photos/seed/100/400/400", description: "Template de blog moderne, responsive et épuré, pour articles et actualités." },
])
const templates = [
  { name: "BusinessPro", screenshot: "https://picsum.photos/seed/1/400/400", description: "Un template moderne pour les entreprises, avec une mise en page responsive et des sections pour services et témoignages." },
  { name: "PortfolioX", screenshot: "https://picsum.photos/seed/2/400/400", description: "Template idéal pour présenter votre portfolio personnel ou vos projets créatifs." },
  { name: "EcomShop", screenshot: "https://picsum.photos/seed/3/400/400", description: "Template e-commerce responsive avec pages produits, panier et checkout intégré." },
  { name: "LandingPagePro", screenshot: "https://picsum.photos/seed/4/400/400", description: "Un template de landing page moderne, conçu pour la conversion avec call-to-action et formulaires intégrés." },
  { name: "BlogMaster", screenshot: "https://picsum.photos/seed/5/400/400", description: "Template de blog élégant, avec mise en page responsive, sections articles et sidebar." },
  { name: "PersonalShape", screenshot: "https://picsum.photos/seed/6/400/400", description: "Portfolio élégant avec un design épuré et responsive." },
  { name: "FirstPortfolio", screenshot: "https://picsum.photos/seed/7/400/400", description: "Template minimaliste pour un portfolio personnel." },
  { name: "Elena", screenshot: "https://picsum.photos/seed/8/400/400", description: "Portfolio moderne pour designers et photographes." },
  { name: "Unfold", screenshot: "https://picsum.photos/seed/9/400/400", description: "Portfolio créatif avec une mise en page unique." },
  { name: "Jackson", screenshot: "https://picsum.photos/seed/10/400/400", description: "Portfolio personnel avec une présentation claire." },
  { name: "Sun", screenshot: "https://picsum.photos/seed/11/400/400", description: "Portfolio lumineux avec un design responsive." },
  { name: "Space", screenshot: "https://picsum.photos/seed/12/400/400", description: "Portfolio avec une ambiance spatiale futuriste." },
  { name: "Rezume", screenshot: "https://picsum.photos/seed/13/400/400", description: "Template de CV en ligne élégant et moderne." },
  { name: "Videograph", screenshot: "https://picsum.photos/seed/14/400/400", description: "Portfolio pour vidéastes et créateurs de contenu." },
  { name: "Glint", screenshot: "https://picsum.photos/seed/15/400/400", description: "Portfolio avec une interface utilisateur moderne." },
  { name: "ChainAppDev", screenshot: "https://picsum.photos/seed/16/400/400", description: "Page de destination pour applications mobiles." },
  { name: "WooxTravel", screenshot: "https://picsum.photos/seed/17/400/400", description: "Template pour agences de voyage." },
  { name: "NexusFlow", screenshot: "https://picsum.photos/seed/18/400/400", description: "Template SaaS avec un design cybernétique." },
  { name: "ZayShop", screenshot: "https://picsum.photos/seed/19/400/400", description: "Template e-commerce avec une interface intuitive." },
  { name: "CatalogZ", screenshot: "https://picsum.photos/seed/20/400/400", description: "Template pour catalogues de produits." },
  { name: "Mexant", screenshot: "https://picsum.photos/seed/21/400/400", description: "Template financier adapté aux sites de crypto-monnaie." },
  { name: "BusinessConsulting1", screenshot: "https://picsum.photos/seed/22/400/400", description: "Template pour cabinets de conseil." },
  { name: "BusinessConsulting2", screenshot: "https://picsum.photos/seed/23/400/400", description: "Template pour consultants et startups." },
  { name: "Accessories", screenshot: "https://picsum.photos/seed/24/400/400", description: "Template pour boutique de bijoux." },
  { name: "LiquorStore", screenshot: "https://picsum.photos/seed/25/400/400", description: "Template pour magasin de spiritueux." },
  { name: "CozaStore", screenshot: "https://picsum.photos/seed/26/400/400", description: "Template e-commerce pour mode et accessoires." },
  { name: "Furn", screenshot: "https://picsum.photos/seed/27/400/400", description: "Template pour magasin de meubles en ligne." },
];

// Charger les templates au montage
onMounted(() => {
  fetchTemplates()
})
</script>

<style scoped>
/* Styles personnalisés si nécessaire */
</style>
