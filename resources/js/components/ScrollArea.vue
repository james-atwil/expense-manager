<template>
  <component :is="tag" ref="element">
    <slot></slot>
  </component>
</template>
<script>
import OverlayScrollbars from "overlayscrollbars";

export default {
  name: "ScrollArea",
  props: {
    tag: {
      type: String,
      default: "div"
    },
    options: {
      type: Object,
      default() {
        return {};
      }
    },
  },
  data() {
    return {
      instance: null
    }
  },
  mounted() {
    this.instance = OverlayScrollbars(this.$refs.element, this.options);
  },
  unmounted() {
    this.instance.destroy();
  }
}
</script>