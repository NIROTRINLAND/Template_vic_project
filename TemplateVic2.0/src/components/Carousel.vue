<template>
  <div class="w-full">
    <Splide
      :options="{
        type: 'loop',
        autoplay: true,
        interval: 2000,
        pagination: true,
        arrows: true,
        heightRatio: 0.35,  // option Splide par défaut, mais facultatif si on utilise h-auto
      }"
      class="w-full"
    >
      <SplideSlide v-for="(slide, index) in slides" :key="index">
        <img
          :src="slide.image"
          :alt="slide.title"
          class="w-full h-auto object-cover"
        />
        <!-- <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 text-white text-center p-2">
          {{ slide.title }}
        </div> -->
      </SplideSlide>
    </Splide>
  </div>
</template>

<script setup>
import { Splide, SplideSlide } from '@splidejs/vue-splide'
import '@splidejs/vue-splide/css'

const slides = [
  { image: 'https://centavolio.one/wp-content/uploads/2023/06/welcome-to-my-blog.png', title: 'Slide 1' },       // hauteur normale
  { image: 'https://templatemo.com/screenshots-720/template-595-3d-coverflow.jpg', title: 'Slide 2' },       // hauteur plus grande
  { image: 'https://templatemo.com/screenshots-720/template-598-sleeky-pro.jpg', title: 'Slide 3' }, 
    { image: 'https://www.tooplate.com/screenshots-720/template-2143-inner-peace.jpg', title: 'Slide 3' },      // hauteur plus petite
]
</script>
