import {createApp, onMounted, reactive, ref} from 'vue';
import {RoleService, UserService} from "../../../services/system/service";

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
        let roleService = new RoleService()
        let userService = new UserService()

        const names = {
            singular: 'User',
            plural: 'Users'
        }

        let record = ref({
            id: 0,
            password: null,
            name_display: null,
            email: null,
            role: null
        })

        const emailExists = (value) => {
            if (value === '' || value === null || value === undefined) {
                return true;
            }

            return new Promise((resolve, reject) => {
                userService.exists(record.value.id, 'email', value).then((response) => {
                    if (response instanceof ServiceError) {
                        toasts.post('danger', response.message)
                        resolve(new yup.ValidationError('Error encountered on remote validation.'))
                    }
                    resolve(!response.data.result)
                }).catch((error) => {
                    toasts.post('danger', error.message)
                    resolve(new yup.ValidationError('Error encountered on remote validation.'))
                })
            })
        };

        let schema = yup.object({
            name_display: yup.string().nullable().required('Field is required.'),
            password: yup.string().nullable().when('id', {
                is: (val) => val == null || val === 0,
                then: (schema) => schema.required('Field is required.')
            }),
            email: yup.string().nullable().email('Invalid email address.')
                .required('Field is required.').test('email-exists', 'Email address is already taken.', emailExists),
            role: yup.object().nullable().required('Field is required.'),
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

        let roles = ref([]);

        let states = reactive({
            loading: false,
            submitting: false
        })

        let formModal = null;
        let deleteModal = null;

        const listDownRoles = async () => {
            states.loading = true;

            let romeo = await roleService.list('l=0&m=1')

            if (romeo instanceof ServiceError) {
                if (toasts !== null) {
                    toasts.post('danger', romeo.message)
                } else {
                    console.error(romeo.message)
                }
            } else {
                roles.value = romeo.data;
            }

            states.loading = false;
        }

        const listDownUsers = async () => {
            states.loading = true;

            let romeo = await userService.list()

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
                    password: null,
                    name_display: null,
                    email: null,
                    role: null
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

                let result = await userService.save(record.value)

                if (result instanceof ServiceError) {
                    toasts.value.post('danger', result.message)
                } else {
                    toasts.value.post('success', 'User has been ' + (record.value.id > 0 ? 'updated' : 'saved') + '.')
                }

                resetForm();
                formModal.hide();

                await listDownUsers();

                states.submitting = false;
            },
            delete: async () => {
                states.submitting = true;

                let result = await userService.destroySingle(record.value)

                if (result instanceof ServiceError) {
                    toasts.value.post('danger', result.message)
                } else {
                    toasts.value.post('success', 'User has been deleted.')
                }

                deleteModal.hide();
                formModal.hide();

                await listDownUsers();

                states.submitting = false;
            }
        }

        onMounted(async () => {
            formModal = Modal.getOrCreateInstance(document.getElementById('modal-form'));
            deleteModal = Modal.getOrCreateInstance(document.getElementById('modal-delete'));

            await listDownRoles()
            await listDownUsers()
        })

        return {
            names,
            toasts,
            states, roleService, result, record, schema,
            actions
        }
    }
};

let app = createApp(IndexComponent)
app.mount('#content');
