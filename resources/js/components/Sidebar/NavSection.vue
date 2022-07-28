<template>
  <li class="nav-item nav-has-child position-relative">
    <a class="nav-link" data-bs-toggle="collapse" :data-bs-target="'#' + id"
       :class="{ 'collapsed': !show,  'active': active }" href="#" @click.prevent="toggle">{{ name }}</a>
    <ul class="nav-sub collapse" :id="id" :class="{ 'show': active }">
      <slot></slot>
    </ul>
  </li>
</template>

<script>
import _ from "lodash";

export default {
  name: "NavSection",
  props: {
    name: {
      type: String,
      required: true
    },
    active: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      id: '',
      show: false,
    }
  },
  methods: {
    toggle() {
      this.show = !this.show
    },
  },
  mounted() {
    const alpha_num = 'abcdefghijklmnopqrstuvwxyz1234567890';
    this.id = 'section-' + _.sampleSize(alpha_num, 5).join('');

    this.show = this.active;
  }
}
</script>
