<template>
  <div class="form-check" v-for="team in teams">
    <input type="checkbox" :id="id" class="form-check-input"
           :value="value[valueField]"
           :checked="isChecked"
           @change="updateInput"
           >
    <label class="form-check-label" :for="id">{{ value[displayField] }}</label>
  </div>
</template>
<script>

export default {
  name: 'TChecklist',
  props: {
    value: {
      type: Object
    },
    displayField: {
      type: String,
      default: 'name'
    },
    valueField: {
      type: String,
      default: 'id'
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
  }
}
</script>