<template>
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div v-for="toast in toasts" :id="toast.id" class="toast" role="alert" :data-bs-delay="toast.delay"
         aria-live="assertive" aria-atomic="true">
      <div class="d-flex alert mb-0" :class="['alert-' + toast.type]">
        <div class="toast-body p-0 me-3 flex-fill">{{ toast.message }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
</template>
<script>
import {ref} from "vue"
import {Toast} from "bootstrap"

export default {
  name: 'TToasts',
  setup() {
    let toasts = ref([])
    let toastMaster = null;

    const post = (type, message, delay = 3000) => {
      const id = 'toast-' + (+new Date())
      toasts.value.push({
        id: id,
        type: type,
        message: message,
        delay: delay
      })

      setTimeout(() => {
        toastMaster = Toast.getOrCreateInstance(document.getElementById(id));
        toastMaster.show()
      }, 10)

    }

    return {
      toasts,
      post
    }
  }
}
</script>