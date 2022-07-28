<template>
  <div class="form-check flex-fill">
    <input :id="id" class="checkbox" type="checkbox"
           :checked="isChecked"
           :value="value[valueField]"
           @change="updateInput($event)">
    <label class="form-check-label" :for="id">
      {{ value[displayField] }}
    </label>
  </div>
</template>

<script>
export default {
  name: "Checkbox",
  props: {
    value: {
      type: Object
    },
    displayField: {
      type: String,
      required: true
    },
    valueField: {
      type: String,
      required: true
    },
    id: {
      type: String,
      required: true
    },
  },
  computed: {
    isChecked() {
      let vueModel = this.$store.state.tsVueModel
      let index = vueModel.map(function(el) { return el.id; }).indexOf(this.value[this.valueField]);

      return index > -1
    }
  },
  methods: {
    updateInput(event) {
      let isChecked = event.target.checked

      if (isChecked) {
        this.$store.commit('add', this.value)
      } else {
        this.$store.commit('remove', this.value)
      }
    }
  },
  beforeMount() {
    delete this.value.children;
  }
}
</script>