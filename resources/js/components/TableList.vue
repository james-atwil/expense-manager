<template>
  <t-toasts ref="toasts"></t-toasts>
  <div :id="id" class="table-grid d-flex flex-column flex-fill">
    <div class="section section-t p-2 d-flex justify-content-between align-items-center">
      <div class="d-flex w-50 justify-content-start">
        <form method="get" class="d-flex w-100" v-on:submit.prevent="search">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search" v-model="query.keywords" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-outline-primary" type="submit" data-bs-toggle="tooltip" title="Perform search">
                <i class="fas fa-fw fa-search"></i>
              </button>
              <button class="btn btn-primary" type="button" data-bs-toggle="tooltip" title="Clear all" @click="clear">
                <i class="fas fa-fw fa-broom"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="button-area ml-auto">
        <slot name="buttons">
          <a class="btn btn-labeled btn-primary" href="#"><span class="btn-label"><i
              class="fas fa-fw fa-sm fa-plus"></i></span> Add New</a>
        </slot>
      </div>
    </div>
    <div class="section section-m flex-fill table-scrollable position-relative">
      <t-overlay :show="states.loading"></t-overlay>
      <table class="table table-bordered table-hover m-0">
        <thead>
          <tr>
            <slot name="thead-columns"></slot>
            <th class="actions actions-sm">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr class="results results-loaded results-0" v-if="result.meta.records.total === 0 && !states.loading">
            <td colspan="10" class="text-center p-5">No results.</td>
          </tr>
          <tr v-if="result.meta.records.total > 0 && !states.loading" v-for="record in result.data">
            <td class="checkbox">
              <input class="form-check-input"
                     type="checkbox"
                     :id="'check-' + record.id"
                     v-model="checkbox.ids"
                     :name="'check-' + record.id"
                     :value="record.id">
            </td>
            <slot name="tbody-first" :record="record">
              <td class="">{{ record.name }}</td>
            </slot>
            <slot name="tbody-columns" :record="record"></slot>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="section section-b p-2 d-flex justify-content-between align-items-center">
      <div class="total">Records: {{ result.meta.records.total }} &#8226; Page {{ query.page }} of
        {{ result.meta.pages.total }}
      </div>
      <t-pagination v-model="query.page" :pages="result.meta.pages.total" @click="search"></t-pagination>
    </div>
  </div>
  <confirm-modal id="confirm-remove-one" ref="modalRemoveOne"
                 color="danger"
                 :spinning="states.submitting"
                 @submit="doRemoveOne"
  >
    <template #title>Delete {{ name.singular }}</template>
    <template #message>
      Are you sure that you will delete the {{ name.singular }} named
      <span class="fw-semibold">{{ record.name }}</span>?
    </template>
  </confirm-modal>
  <confirm-modal id="confirm-remove-sel" ref="modalRemoveSel"
                 color="danger"
                 :spinning="states.submitting"
                 @submit="doRemoveSel"
  >
    <template #title>Delete Selected {{ name.plural }}</template>
    <template #message>
      Are you sure that you will delete the selected {{ name.plural }}?
    </template>
  </confirm-modal>
</template>
<script>
import {onMounted, ref, reactive, watch} from "vue"

import TToasts from "./Toasts";
import TOverlay from "./Overlay"
import TPagination from "./Pagination"
import ConfirmModal from "./Modal/Confirm"

import Service from "../services/service";
import ServiceError from "../services/errors";

class Names {
  singular = ''
  plural = ''
}

export default {
  components: {
    TToasts,
    TOverlay,
    TPagination,
    ConfirmModal
  },
  name: "TableList",
  props: {
    id: {
      type: String,
      default: "table-list"
    },
    service: {
      type: Service
    },
    names: {
      type: Object
    }
  },
  setup(props) {
    let service = props.service;
    let name = props.names

    let toasts = ref(null);

    let states = reactive({
      loading: false,
      submitting: false,
    })

    let modalRemoveOne = ref(null);
    let modalRemoveSel = ref(null);

    let query = ref({
      keywords: '',
      page: 1
    })
    let result = ref({
      success: true,
      data: [],
      meta: {
        records: {},
        pages: {},
      }
    })
    let record = ref({
      id: null,
      name: null
    })

    let checkbox = reactive({
      ids: [],
      all: false
    })

    const clear = () => {
      query.value = {
        keywords: '',
        page: 1
      }
    }

    const search = async () => {
      states.loading = true;

      let qs = [];
      qs.push('q=' + query.value.keywords)
      qs.push('p=' + query.value.page)

      let romeo = await service.list(qs.join('&'))

      if (romeo instanceof ServiceError) {
        if (toasts !== null) {
          toasts.post('danger', romeo.message)
        } else {
          console.error(romeo.message)
        }
      } else {
        result.value = romeo;
      }

      states.loading = false;
    }

    const showRemoveOne = (rec) => {
      record.value = rec
      modalRemoveOne.value.show();
    }

    const showRemoveSel = (rec) => {
      record.value = rec
      modalRemoveSel.value.show();
    }

    const doRemoveOne = async () => {
      if (record.value === null) {
        console.warn('No record selected. Unable to carry on to process.')
        return
      }

      states.submitting = true;

      let result = await service.destroySingle(record.value)
      modalRemoveOne.value.hide();

      if (result instanceof ServiceError) {
        toasts.value.post('danger', result.message)
      } else {
        toasts.value.post('success', name.singular + ' has been deleted.')
        await search();
      }

      states.submitting = false;
    }

    const doRemoveSel = async () => {
      states.submitting = true;

      let result = await service.destroyMultiple(checkbox.ids)
      modalRemoveSel.value.hide();

      if (result instanceof ServiceError) {
        toasts.value.post('danger', result.message)
      } else {
        toasts.value.post('success', 'Selected ' + name.plural + ' has been deleted.')
        checkbox.ids = [];
        await search();
      }

      states.submitting = false;
    }

    watch(() => checkbox.all, () => {
      checkbox.ids = [];
      if (checkbox.all) {
        for (let d of result.value.data) {
          checkbox.ids.push(d.id);
        }
      }
    })

    onMounted(async () => {
      if (window.bbxca.message != null) {
        toasts.value.post(window.bbxca.message.status, window.bbxca.message.content)
      }

      clear()
      await search()
    })

    return {
      toasts, modalRemoveOne, modalRemoveSel,
      name, states, query, result, record, checkbox,
      clear, search, showRemoveOne, showRemoveSel, doRemoveOne, doRemoveSel
    }
  }
}
</script>
