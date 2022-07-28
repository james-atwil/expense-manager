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
import {Form, Field, useForm} from "vee-validate";
import {Modal} from "bootstrap";


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
        let userService = new UserService()

        const names = {
            singular: 'User',
            plural: 'Users'
        }

        let record = ref({
            id: 0,
            password: null
        })


        let schema = yup.object({
            password: yup.string().required('Field is required.')
        });

        let toasts = ref(null);

        let states = reactive({
            loading: false,
            submitting: false
        })

        let actions = {
            submit: async (values, {resetForm}) => {
                states.submitting = true;

                let result = await userService.changePass(record.value)

                if (result instanceof ServiceError) {
                    toasts.value.post('danger', result.message)
                } else {
                    toasts.value.post('success', 'User has been ' + (record.value.id > 0 ? 'updated' : 'saved') + '.')
                }

                resetForm();

                states.submitting = false;
            },
        }

        return {
            names,
            toasts, schema,
            states, record,
            actions
        }
    }
};

let app = createApp(IndexComponent)
app.mount('#content');
