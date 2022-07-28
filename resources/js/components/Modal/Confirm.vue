<template>
  <div class="modal fade" :id="id" tabindex="-1" role="dialog" :aria-labelledby="id + '-title'" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form @submit.prevent="$emit('submit')">
          <div class="modal-header text-white" :class="['bg-' + color]">
            <h5 class="modal-title" :id="id + '-title'">
              <slot name="title">Modal</slot>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <slot name="message"></slot>
          </div>
          <div class="modal-footer py-2">
            <button type="submit" class="btn btn-labeled" :class="['btn-' + color]">
              <span class="btn-label"><i :class="[spinning ? 'fa-cog fa-spin' : labelOk.icon]"
                                         class="fas fa-fw"></i></span> {{ labelOk.text }}
            </button>
            <button type="button" class="btn btn-secondary btn-labeled" data-bs-dismiss="modal">
              <span class="btn-label"><i :class="[spinning ? 'fa-cog fa-spin' : labelCancel.icon]"
                                         class="fas fa-fw"></i></span> {{ labelCancel.text }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import {onMounted, toRef} from "vue"
import {Modal} from "bootstrap";

class Indicator {
  icon = ''
  text = ''

  constructor(icon, text) {
    this.icon = icon
    this.text = text
  }
}

export default {
  name: "ConfirmModal",
  props: {
    id: {
      type: String,
      default: 'modal-' + (+new Date())
    },
    color: {
      type: String,
      default: "primary"
    },
    labelOk: {
      type: Object,
      default: {
        icon: 'fa-thumbs-up',
        text: 'Yes'
      }
    },
    labelCancel: {
      type: Object,
      default: {
        icon: 'fa-times',
        text: 'No'
      }
    },
    spinning: {
      type: Boolean,
      default: false
    }
  },
  emits: ['submit'],
  setup(props) {
    let id = props.id;
    let labelOk = props.labelOk
    let labelCancel = props.labelCancel
    let spinning = toRef(props.spinning, 'spinning')

    let modal = null

    const show = () => {
        modal.show()
    }

    const hide = () => {
      modal.hide()
    }

    onMounted(() => {
      modal = Modal.getOrCreateInstance(document.getElementById(id));
    })

    return {
      id, labelOk, labelCancel, spinning,
      show, hide
    }
  }
}
</script>