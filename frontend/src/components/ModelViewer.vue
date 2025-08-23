<template>
  <model-viewer
    :src="modelSrc"
    alt="A 3D dish"
    ar
    ar-modes="webxr scene-viewer quick-look"
    camera-controls
    auto-rotate
    style="width: 100%; height: 500px"
  >
    <button slot="ar-button" style="background: #000; color: white; padding: 10px 20px;">
      View in AR
    </button>
  </model-viewer>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  modelSrc: {
    type: String,
    required: true
  }
})
</script>
