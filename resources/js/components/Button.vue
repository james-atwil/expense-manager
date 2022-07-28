<template>
  <button :class="['btn', {'btn-lg': size === 'lg', 'btn-sm': size === 'sm'}, 'btn-' + color, { 'btn-labeled': face === 'labeled'}]"
          :type="type"
          :disabled="spinning"
          @click="$emit('click', $event);">
    <span v-if="face === 'labeled'" class="btn-label"><i :class="['fas', 'fa-fw', spinning ? iconSpin + ' fa-spin cursor-disabled': iconBase]"></i></span> <slot></slot>
  </button>
</template>
<script>
export default {
  name: 'TButton',
  props: {
    face: {
      type: String,
      default: 'labeled',
    },
    type: {
      type: String,
      default: 'button',
    },
    size: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: 'primary',
    },
    iconBase: {
      type: String,
      default: 'fa-upload',
    },
    iconSpin: {
      type: String,
      default: 'fa-cog',
    },
    spinning: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['click']
}
</script>