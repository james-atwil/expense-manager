import {createApp, onMounted, reactive, ref} from 'vue';
import {CategoryService} from "../../../services/expenses/service";

import TToasts from "../../../components/Toasts";
import TInput from "../../../components/Input/Text";
import TTextarea from "../../../components/Input/Textarea";
import TButton from "../../../components/Button";
import TOverlay from "../../../components/Overlay";

import ServiceError from "../../../services/errors";
import * as yup from "yup";
import {Modal} from "bootstrap";
import {Form, useForm} from "vee-validate";


const IndexComponent = {
    components: {
        TOverlay,
        TToasts,
        VForm: Form,
        TInput,
        TTextarea,
        TButton
    },
    setup() {
        let service = new CategoryService()
        const names = {
            singular: 'Category',
            plural: 'Categories'
        }

        const schema = yup.object({
            name: yup.string().nullable().required('Field is required.'),
        });

        let toasts = ref(null);

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
            name: null,
            description: null
        })

        let states = reactive({
            loading: false,
            submitting: false
        })

        let formModal = null;
        let deleteModal = null;

        const listDown = async () => {
            states.loading = true;

            let romeo = await service.list()

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

        let actions = {
            addNew: () => {
                record.value = {
                    id: 0,
                    name: null,
                    description: null
                }
                formModal.show();
            },
            edit: (romeo) => {
                record.value = romeo;
                formModal.show()
            },
            confirmDelete: () => {
                deleteModal.show()
            },

            submit: async (values, {resetForm}) => {
                states.submitting = true;

                let result = await service.save(record.value)

                if (result instanceof ServiceError) {
                    toasts.value.post('danger', result.message)
                } else {
                    toasts.value.post('success', 'Category has been ' + (record.value.id > 0 ? 'updated' : 'saved') + '.')
                }

                resetForm();
                formModal.hide();

                await listDown();

                states.submitting = false;
            },
            delete: async () => {
                states.submitting = true;

                let result = await service.destroySingle(record.value)

                if (result instanceof ServiceError) {
                    toasts.value.post('danger', result.message)
                } else {
                    toasts.value.post('success', 'Category has been deleted.')
                }

                deleteModal.hide();
                formModal.hide();

                await listDown();

                states.submitting = false;
            }
        }

        onMounted(async () => {
            formModal = Modal.getOrCreateInstance(document.getElementById('modal-form'));
            deleteModal = Modal.getOrCreateInstance(document.getElementById('modal-delete'));

            await listDown()
        })

        return {
            service, names,
            toasts,
            states, result, record, schema,
            actions
        }
    }
};

let app = createApp(IndexComponent)
app.mount('#content');
