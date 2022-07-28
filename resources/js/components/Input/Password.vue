<template>
    <v-field v-slot="{ field, meta, errorMessage }" :name="name" v-model="modelValue" :validateOnInput="true">
        <div class="form-group row">
            <label v-if="label !== '' && label !== null" :for="name" class="col-sm-3 col-form-label">{{ label }} <sup
                v-if="required" class="text-danger"><i class="fas fa-sm fa-asterisk"></i></sup></label>
            <div class="col-sm-9">
                <div class="input-group">
                    <input :type="passOpen ? 'text' : 'password'" class="form-control"
                           v-bind="field"
                           :id="name"
                           :disabled="disabled"
                           :class="{ 'is-valid': meta.touched && meta.valid, 'is-invalid': meta.touched && !meta.valid }"
                           @input="handleInput"
                    >
                    <button class="btn btn-outline-secondary" type="button" id="button" @click="toggle">
                        <i class="fas fa-fw" :class="{ 'fa-eye': !passOpen, 'fa-eye-slash': passOpen }"></i>
                    </button>
                </div>
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
    name: 'TPassword',
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
            default: '',
        },
        required: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        btnColor: {
            type: String,
            default: 'secondary',
        }
    },
    emits: ['update:modelValue'],
    data() {
        return {
            passOpen: false,
        }
    },
    methods: {
        toggle() {
            this.passOpen = !this.passOpen;
        },
        handleInput(event) {
            this.$emit('update:modelValue', event.target.value);
        },
    }
}
</script>
