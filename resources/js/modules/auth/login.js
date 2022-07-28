import {createApp} from 'vue';
import {Form, Field, ErrorMessage} from 'vee-validate';
import * as yup from 'yup';

const LoginComponent = {
    components: {
        VForm: Form,
        VField: Field,
        ErrorMessage: ErrorMessage,
    },
    data() {
        const schema = yup.object({
            username: yup.string().required(),
            password: yup.string().required(),
        });
        return {
            url: {
                path: '/login'
            },
            success: false,
            invalid: false,
            schema: schema,
            login: {
                username: '',
                password: '',
                redirect: '',
                remember: 0
            }
        }
    },
    methods: {
        dismiss: function () {
            setTimeout(() => {
                this.invalid = false;
            }, 3000);
        },
        submit: function () {
            let that = this;

            axios({
                method: 'POST',
                url: that.url.path,
                data: that.login
            }).then(function (response) {
                if (response.data.result) {
                    that.success = true;
                    window.location = response.data.redirect;
                } else {
                    that.invalid = true;
                    that.dismiss();
                }
            });
        }
    }
}

let app = createApp(LoginComponent)
app.mount('#module');
