<script setup>
import { ref, onMounted } from 'vue'
import { useTemplateStore } from '../stores/template'
import { apiClient } from './axios.config.mjs'

const TemplateStore = useTemplateStore()
const template = TemplateStore.template

const templateHtml = ref('')


onMounted(() => {
 templateHtml.value=`${ import.meta.env.VITE_API_URL2 }/storage/templates/${TemplateStore.template.name}/index.html`
})
</script>

<template>
    <iframe :src="templateHtml" style="width:100%; height:100vh;"></iframe>
</template>
