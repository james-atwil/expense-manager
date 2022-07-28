<template>
  <div :id="id" class="bsv-tree-select position-relative" v-clickoutside="clickOutside" @change="updateValue">
    <div class="tag-box justify-content-between dropdown-toggle" :class="[state]" @click.prevent="showChecklist">
      <div class="tag-list d-flex flex-wrap">
        <span class="tag d-flex px-2 mr-2 justify-content-between bg-light small" v-for="item in value">
          <span class="tag-item pr-2">{{ item[displayField] }}</span>
          <button type="button" class="close-tag" aria-label="Remove Tag" @click.prevent="remove(item)">
            <span aria-hidden="true">&times;</span>
          </button>
        </span>
      </div>
    </div>
    <div class="dropdown-tree" :class="{ 'd-block': open }">
      <TreeList :items="items"
                :display-field="displayField"
                :value-field="valueField">
      </TreeList>
    </div>
  </div>
</template>

<script>
import _ from "lodash";
import Vue from "vue";
import Vuex from "vuex";
import TreeList from "./TreeList";

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    tsVueModel: []
  },
  mutations: {
    add (state, element) {
      state.tsVueModel.push(element)
    },
    remove(state, element) {
      state.tsVueModel.splice(state.tsVueModel.indexOf(element), 1)
    },
    set(state, array) {
      state.tsVueModel = array
    }
  },
  actions: {
    add(context, element) {
      context.commit('add', element)
    },
    remove(context, element) {
      context.commit('remove', element)
    },
    set(context, array) {
      context.commit('set', array)
    }
  }
})

export default {
  components: {
    TreeList
  },
  store: store,
  inheritAttrs: false,
  name: "TreeSelect",
  inject: {
    $validator: '$validator'
  },
  props: {
    id: {
      type: String,
      required: true
    },
    name: {
      type: String,
      default() {
        return 'treeselect_' + _.sampleSize('abcdefghijklmnopqrstuvwxyz1234567890', 5).join('');
      }
    },
    items: {
      type: Array,
      required: true
    },
    value: {
      type: Array
    },
    displayField: {
      type: String,
      default: 'name'
    },
    valueField: {
      type: String,
      default: 'id'
    },
    state: {
      type: String,
    }
  },
  directives: {
    clickoutside: {
      bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
          if (!(el === event.target || el.contains(event.target))) {
            vnode.context[binding.expression](event);
          }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
      },
      unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
      },
      stopProp(event) { event.stopPropagation() }
    }
  },
  data() {
    return {
      open: false,
    }
  },
  computed: {
    internalValue: {
      get () {
        return this.$store.state.tsVueModel
      },
      set(value) {
        this.$store.commit('set', value)
      }
    },
  },
  methods: {
    showChecklist() {
      this.open = true;
    },
    clickOutside() {
      this.open = false;
    },
    remove(item) {
      let index = this.internalValue.map(function(e) { return e.id; }).indexOf(item.id);
      this.internalValue.splice(index, 1);

      this.$emit('input', this.internalValue)
    },
    updateValue() {
      this.$emit('input', this.internalValue)
    }
  },
  mounted() {
    this.$store.commit('set', this.value)
  }
}
</script>
