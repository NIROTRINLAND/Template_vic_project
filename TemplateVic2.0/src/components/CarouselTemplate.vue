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
  { image: 'https://webypress.fr/wp-content/uploads/2020/01/1580121650_458_15-meilleurs-modeles-de-sites-Web-de-sites-demploi-2020.jpg', title: 'Slide 1' },       // hauteur normale
  { image: 'https://webypress.fr/wp-content/uploads/2020/02/1580554255_850_28-meilleurs-modeles-de-sites-Web-dhebergement-Web-HTML-2020.jpg', title: 'Slide 2' },       // hauteur plus grande
  { image: 'https://webypress.fr/wp-content/uploads/2020/02/1580554257_861_28-meilleurs-modeles-de-sites-Web-dhebergement-Web-HTML-2020.jpg', title: 'Slide 3' }, 
    { image: 'https://webypress.fr/wp-content/uploads/2020/02/1580554256_190_28-meilleurs-modeles-de-sites-Web-dhebergement-Web-HTML-2020.jpg', title: 'Slide 3' },      // hauteur plus petite
]
</script>
