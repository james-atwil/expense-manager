<template>
  <div class="overlay d-flex justify-content-center align-items-start position-absolute" v-if="show">
    <div class="spinner-wrapper text-center">
      <div class="spinner-border text-primary" role="status"></div>
      <div class="mt-2">Loading... please wait.</div>
    </div>
  </div>
</template>
<script>
export default {
  name: "TOverlay",
  props: {
    show: {
      type: Boolean,
      default: true,
    },
  },
  emits: ['update:modelValue'],
}
</script>
