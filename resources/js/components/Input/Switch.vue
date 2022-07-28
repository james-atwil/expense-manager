<template>
  <v-field v-slot="{ field }" :name="name" v-model="modelValue" :validateOnInput="true">
    <div class="form-group form-group-switch">
      <label class="d-block" v-if="label !== '' && label !== null">
        <input type="checkbox" v-model="modelValue"
               :id="name" :name="name" :true-value="trueValue" :false-value="falseValue" :disabled="disabled"
               @change="updateInput">
        <span class="label-wrapper d-flex align-items-center justify-content-between">
            <span class="content">{{ label }}</span>
            <span class="slider-wrapper"><span class="slider"></span></span>
          </span>
      </label>
      <div class="slot">
        <slot></slot>
      </div>
    </div>
  </v-field>
</template>
<script>
import { Field } from "vee-validate";

export default {
  components : {
    VField: Field,
  },
  name: 'TSwitch',
  props: {
    name: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      default: 'text',
    },
    label: {
      type: String,
      default: '',
    },
    modelValue: {
      default: '',
    },
    trueValue: {
      default: true,
    },
    falseValue: {
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['update:modelValue'],
  data() {
    return {
      checked: this.modelValue,
    };
  },
  methods: {
    updateInput(event) {
      let isChecked = event.target.checked
      this.$emit('update:modelValue', isChecked ? this.trueValue : this.falseValue)
    }
  }
}
</script>