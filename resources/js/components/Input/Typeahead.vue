<template>
    <v-field v-slot="{ field, meta, errorMessage }" :name="name" v-model="modelValue" :validateOnInput="true">
        <div class="form-group row">
            <label v-if="label !== '' && label !== null" :for="name" class="col-sm-3 col-form-label">{{ label }} <sup
                v-if="required" class="text-danger"><i class="fas fa-sm fa-asterisk"></i></sup></label>
            <div class="col-sm-9">
                <div
                    :class="['t-typeahead', 'position-relative', {'tdb-typeahead-sm': small, 'tdb-typeahead-lg': large}]"
                    v-click-outside="clickOutside">
                    <div
                        :class="['input-group', 'input-group-typeahead', {'input-group-sm' : small, 'input-group-lg': large}]">
                        <input type="text"
                               :id="name"
                               :name="name"
                               :class="['form-control', {'form-control-sm': small, 'form-control-lg': large, 'is-valid': meta.touched && meta.valid, 'is-invalid': meta.touched && !meta.valid }]"
                               :value="query"
                               @focus="dropList"
                               @input="updateValue"
                               @keydown.enter.prevent='enter'
                               @keydown.down.prevent='down'
                               @keydown.up.prevent='up'
                        >
                        <button v-if="query !== ''" type="button" :class="['btn', 'btn-input']" @click="clear">
                            <slot name="icon-clear"><i class="fas fa-fw fa-times"></i></slot>
                        </button>
                        <button type="button"
                                :class="['btn', 'btn-input', {'btn-sm' : small, 'btn-lg': large, 'is-valid': meta.touched && meta.valid, 'is-invalid': meta.touched && !meta.valid}, ]"
                                @click="dropList">
                            <slot name="icon-drop"><i class="fas fa-fw fa-chevron-down"></i></slot>
                        </button>
                    </div>

                    <ul ref="options_list" class="dropdown-menu w-100 m-0 p-0" :class="{ 'd-block': open }">
                        <li ref="options" class="cursor-pointer dropdown-item" v-for="(item, index) in items"
                            :class="{'active': isActive(index) }"
                            @click.prevent.stop="selectValue(item)"
                        >
                            <slot name="option" :item="item">{{ item[displayField] }}</slot>
                        </li>
                    </ul>
                </div>
                <div v-if="meta.touched && !meta.valid" class="mt-1 d-block invalid-feedback">{{ errorMessage }}</div>
            </div>
        </div>
    </v-field>
</template>
<script>
import _ from 'lodash';
import {Field} from "vee-validate";

export default {
    components: {
        VField: Field,
    },
    name: 'TTypeahead',
    props: {
        name: {
            type: String,
            required: true
        },
        label: {
            type: String,
            default: ''
        },
        modelValue: {
            type: Object,
        },
        idField: {
            type: String,
            default: 'id'
        },
        displayField: {
            type: String,
            default: 'name'
        },
        url: {
            type: String,
            required: true
        },
        required: {
            type: Boolean,
            default: false,
        },
        small: {
            type: Boolean,
            default: false
        },
        large: {
            type: Boolean,
            default: false
        },
        debounce: {
            type: Number,
            default: 350
        },
    },
    data() {
        return {
            open: false,
            current: 0,
            query: '',
            fnDebounce: null,
            items: [],
        }
    },
    directives: {
        clickOutside: {
            beforeMount: (el, binding) => {
                el.clickOutsideEvent = event => {
                    if (!(el === event.target || el.contains(event.target))) {
                        binding.value();
                    }
                };
                document.addEventListener("click", el.clickOutsideEvent);
            },
            unmounted: el => {
                document.removeEventListener("click", el.clickOutsideEvent);
            },
        }
    },
    emits: ['update:modelValue'],
    methods: {
        isActive(index) {
            return index === this.current
        },
        selectValue(item) {
            this.query = item[this.displayField];
            this.open = false;
            this.items = [];
            this.current = 0;
            this.$emit('update:modelValue', item)
        },
        clear() {
            this.query = '';
            this.$emit('update:modelValue', null)
        },
        enter() {
            if (this.items.length < 1) {
                return
            }
            this.selectValue(this.items[this.current])
        },
        up() {
            if (this.current > 0) {
                this.current--
                this.scroll()
            }
        },
        down() {
            if (this.current < this.items.length - 1) {
                this.current++
                this.scroll()
            }
        },
        performSearch() {
            let that = this;
            axios.get(that.url.replace('%q%', this.query)).then(response => {
                that.items = response.data.data;
            });
        },
        dropList() {
            this.performSearch()
            this.open = true;
        },
        clickOutside() {
            this.query = (this.modelValue === null || this.modelValue === undefined) ? '' : this.modelValue[this.displayField];
            this.open = false;
            this.items = [];
            this.current = 0;
        },
        scroll() {
            const li_h = this.$refs.options[this.current].clientHeight;
            this.$refs.options_list.scrollTop = li_h * this.current;
        },
        updateValue() {
            this.fnDebounce();
        }
    },
    created() {
        this.fnDebounce = _.debounce(() => {
            let that = this;

            this.current = 0;

            that.performSearch();
            that.open = true;
        }, this.debounce)
    },
    beforeMount() {
        if (this.modelValue !== null) {
            this.query = this.modelValue[this.displayField]
        }
    }
}
</script>
