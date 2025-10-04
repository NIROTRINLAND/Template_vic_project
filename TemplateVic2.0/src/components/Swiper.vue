<template>
  <Swiper
    :loop="true"
    :autoplay="{ delay: 3000 }"
    :modules="[Autoplay, Pagination, Navigation]"
    pagination
    navigation
    class="mySwiper"
  >
    <SwiperSlide v-for="(slide, index) in slides" :key="index">
      <img :src="slide.image" :alt="slide.title" class="w-full h-64 object-cover" />
    </SwiperSlide>
  </Swiper>
</template>

<script setup>
import { Swiper, SwiperSlide } from 'swiper/vue'

// ✅ Importer les modules depuis leurs chemins dédiés
import { Autoplay } from 'swiper/modules/autoplay/autoplay.js'
import { Pagination } from 'swiper/modules/pagination/pagination.js'
import { Navigation } from 'swiper/modules/navigation/navigation.js'

// Importer les CSS nécessaires
import 'swiper/css'
import 'swiper/css/pagination'
import 'swiper/css/navigation'

const slides = [
  { image: 'https://picsum.photos/800/400?random=1', title: 'Slide 1' },
  { image: 'https://picsum.photos/800/400?random=2', title: 'Slide 2' },
  { image: 'https://picsum.photos/800/400?random=3', title: 'Slide 3' },
]
</script>
