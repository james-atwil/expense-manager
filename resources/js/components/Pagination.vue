<template>
  <nav aria-label="Page navigation">
    <ul class="pagination m-0">
      <li class="page-item" :class="{ 'disabled': this.modelValue === 1 }" v-if="showFirst" @click.prevent="goToFirst">
        <a class="page-link" href="#">
          <span v-if="icons"><i class="fas fa-angle-double-left"></i></span>
          <span v-else>{{ strFirst }}</span>
        </a>
      </li>
      <li class="page-item" :class="{ 'disabled': this.modelValue === 1 }" >
        <a class="page-link" href="#" @click.prevent="goToPrev">
          <span v-if="icons"><i class="fas fa-angle-left"></i></span>
          <span v-else>{{ strPrev }}</span>
        </a>
      </li>
      <li class="page-item" v-for="n in pageList" :class="{ 'active': n === this.modelValue}">
        <a class="page-link" href="#" @click.prevent="goToPage(n)">{{ n }}</a>
      </li>
      <li class="page-item" :class="{ 'disabled': this.modelValue === this.pages }">
        <a class="page-link" href="#" @click.prevent="goToNext">
          <span v-if="icons"><i class="fas fa-angle-right"></i></span>
          <span v-else>{{ strNext }}</span>
        </a>
      </li>

      <li class="page-item" :class="{ 'disabled': this.modelValue === this.pages }" v-if="showLast">
        <a class="page-link" href="#" @click.prevent="goToLast">
          <span v-if="icons"><i class="fas fa-angle-double-right"></i></span>
          <span v-else>{{ strLast }}</span>
        </a>
      </li>
    </ul>
  </nav>
</template>
<script>
export default {
  name: "TPagination",
  props: {
    modelValue: {
      type: Number,
      default: 1,
    },
    pages: {
      type: Number,
      default: 1,
    },
    range: {
      type: Number,
      default: 5,
    },
    showFirst: {
      type: Boolean,
      default: true,
    },
    showLast: {
      type: Boolean,
      default: true,
    },
    icons: {
      type: Boolean,
      default: true,
    },
    strFirst: {
      type: String,
      default: 'First',
    },
    strPrev: {
      type: String,
      default: 'Prev',
    },
    strNext: {
      type: String,
      default: 'Next',
    },
    strLast: {
      type: String,
      default: 'Last',
    },
  },
  emits: ['update:modelValue'],
  data() {
    return {
      rangeStart: 1,
      rangeEnd: this.range,
      pageList: []
    }
  },
  watch: {
    modelValue(newVal, oldVal) {
      this.adjustRange()
    },
    pages(newVal, oldVal) {
      this.adjustRange()
    }
  },
  methods: {
    goToFirst() {
      this.$emit('update:modelValue', 1)
    },
    goToPrev() {
      let futurePage = this.modelValue - 1;
      if (futurePage > 0) {
        this.$emit('update:modelValue', this.modelValue - 1)
      }
    },
    goToPage(n) {
      this.$emit('update:modelValue', n)
    },
    goToNext() {
      let futurePage = this.modelValue + 1;
      if (futurePage <= this.pages) {
        this.$emit('update:modelValue', this.modelValue + 1)
      }
    },
    goToLast() {
      this.$emit('update:modelValue', this.pages)
    },
    adjustRange() {
      this.pageList = [];
      if (this.range >= this.pages) {
        for (let n = 1; n <= this.pages; n++) this.pageList.push(n);
      } else {
        if (this.modelValue <= this.range) {
          for (let n = 1; n <= this.range; n++) this.pageList.push(n);
        } else if (this.modelValue >= this.pages - this.range) {
          for (let n = this.pages - this.range; n <= this.pages; n++) this.pageList.push(n);
        } else {
          if (this.modelValue < this.rangeStart || this.modelValue > this.rangeEnd) {
            this.rangeStart = this.modelValue - (this.range - 1);
            this.rangeEnd = this.modelValue
          }
          for (let n = this.rangeStart; n <= this.rangeEnd; n++) this.pageList.push(n);
        }
      }
    }
  },
  mounted() {
    this.adjustRange()
  }
}
</script>
