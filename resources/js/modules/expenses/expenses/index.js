import {createApp, onMounted, reactive, ref} from 'vue';
import {CategoryService, ExpenseService} from "../../../services/expenses/service";

import TToasts from "../../../components/Toasts";
import TInput from "../../../components/Input/Text";
import TTextarea from "../../../components/Input/Textarea";
import TPassword from "../../../components/Input/Password";
import TTypeahead from "../../../components/Input/Typeahead";
import TButton from "../../../components/Button";
import TOverlay from "../../../components/Overlay";

import ServiceError from "../../../services/errors";
import * as yup from "yup";
import {Modal} from "bootstrap";
import {Form, Field, useForm} from "vee-validate";



const IndexComponent = {
    components: {
        TOverlay,
        TToasts,
        VForm: Form,
        VField: Field,
        TInput,
        TTextarea,
        TPassword,
        TTypeahead,
        TButton
    },
    setup() {
        let categoryService = new CategoryService()
        let expenseService = new ExpenseService()

        const names = {
            singular: 'Expense',
            plural: 'Expenses'
        }

        let record = ref({
            id: 0,
            name: null,
            category: null,
            amount: null,
            entry_at: null,
        })

        let schema = yup.object({
            name: yup.string().nullable().required('Field is required.'),
            category: yup.object().nullable().required('Field is required.'),
            amount: yup.string().nullable().required('Field is required.').matches(/^[1-9]\d*(((,\d{3}){1})?(\.\d{0,2})?)$/,  { message: 'Accepts only numbers and decimal point.', excludeEmptyString: true }),
            entry_at: yup.date().nullable().required('Field is required.').max(new Date(), 'Not later than today.')
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

        let states = reactive({
            loading: false,
            submitting: false
        })

        let formModal = null;
        let deleteModal = null;

        const listDownExpenses = async () => {
            states.loading = true;

            let romeo = await expenseService.list()

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
                    category: null,
                    amount: null,
                    entry_at: null,
                }
                formModal.show();
            },
            edit: async (romeo) => {
                record.value = JSON.parse(JSON.stringify(romeo));
                formModal.show()
            },
            confirmDelete: () => {
                deleteModal.show()
            },

            submit: async (values, {resetForm}) => {
                states.submitting = true;

                let result = await expenseService.save(record.value)

                if (result instanceof ServiceError) {
                    toasts.value.post('danger', result.message)
                } else {
                    toasts.value.post('success', 'Expense has been ' + (record.value.id > 0 ? 'updated' : 'saved') + '.')
                }

                resetForm();
                formModal.hide();

                await listDownExpenses();

                states.submitting = false;
            },
            delete: async () => {
                states.submitting = true;

                let result = await expenseService.destroySingle(record.value)

                if (result instanceof ServiceError) {
                    toasts.value.post('danger', result.message)
                } else {
                    toasts.value.post('success', 'Expense has been deleted.')
                }

                deleteModal.hide();
                formModal.hide();

                await listDownExpenses();

                states.submitting = false;
            }
        }

        onMounted(async () => {
            formModal = Modal.getOrCreateInstance(document.getElementById('modal-form'));
            deleteModal = Modal.getOrCreateInstance(document.getElementById('modal-delete'));

            await listDownExpenses()
        })

        return {
            names,
            toasts,
            states, categoryService, result, record, schema,
            actions
        }
    }
};

let app = createApp(IndexComponent)
app.mount('#content');
