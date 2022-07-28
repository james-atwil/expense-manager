<template>
  <div class="d-inline-block dropdown nav-item nav-item-avatar">
    <a class="avatar text-white" href="#" data-bs-toggle="dropdown" aria-expanded="false">
      <div class="avatar-letters">{{ initials }}</div>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
      <slot></slot>
    </ul>
  </div>
</template>

<script>
export default {
  name: "Avatar",
  props: {
    initials: {
      type: String,
      required: true
    }
  }
}
</script>
