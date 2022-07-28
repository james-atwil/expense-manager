<template>
  <v-field v-slot="{ field, meta, errorMessage }" :name="name" v-model="modelValue" :validateOnInput="true">
    <div class="form-group row">
      <label v-if="label !== '' && label !== null" :for="name" class="col-sm-3 col-form-label">{{ label }} <sup v-if="required" class="text-danger"><i class="fas fa-sm fa-asterisk"></i></sup></label>
      <div class="col-sm-9">
          <input :type="type"
                 class="form-control"
                 v-bind="field"
                 :id="name"
                 :placeholder="placeholder"
                 :disabled="disabled"
                 :class="{ 'is-valid': meta.touched && meta.valid, 'is-invalid': meta.touched && !meta.valid }"
                 @input="handleInput"
          >
          <div v-if="meta.touched && !meta.valid" class="mt-1 d-block invalid-feedback">{{ errorMessage }}</div>
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
  name: 'TInput',
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
    placeholder: {
      type: String,
      default: "",
    },
    required: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['update:modelValue'],
  methods: {
    handleInput(event) {
      this.$emit('update:modelValue', event.target.value);
    },
  }
}
</script>
