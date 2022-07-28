<template>
    <v-field v-slot="{ field, meta, errorMessage }" :name="name" v-model="modelValue" :validateOnInput="true">
        <div class="form-group row">
            <label v-if="label !== '' && label !== null" :for="name" class="col-sm-3 col-form-label">{{ label }}
                <sup v-if="required" class="text-danger"><i class="fas fa-sm fa-asterisk"></i></sup>
            </label>
            <div class="col-sm-9">
                <textarea class="form-control"
                          :id="name"
                          :name="name"
                          :value="modelValue"
                          :rows="rows"
                          :placeholder="placeholder"
                          :disabled="disabled"
                          :class="{ 'is-valid': meta.touched && meta.valid, 'is-invalid': meta.touched && !meta.valid }"
                          @input="handleInput"
                ></textarea>
                <div v-if="meta.touched && !meta.valid" class="mt-1 d-block invalid-feedback">{{ errorMessage }}</div>
                <slot></slot>
            </div>
        </div>
    </v-field>
</template>
<script>
import {Field} from "vee-validate";

export default {
    components: {
        VField: Field,
    },
    name: 'TTextarea',
    props: {
        name: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            default: '',
        },
        modelValue: {
            type: String,
            default: "",
        },
        rows: {
            type: Number,
            default: 5,
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
