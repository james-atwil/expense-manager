<template>
  <li class="nav-item"><a class="nav-link" :class="{ 'active': active }" :href="href" :target="target"><slot></slot></a></li>
</template>

<script>
export default {
  name: "NavItem",
  props: {
    href: {
      type: String,
      required: true
    },
    target: {
      type: String,
      default: "_self"
    },
    active: {
      type: Boolean,
      default: false
    }
  }
}
</script>
