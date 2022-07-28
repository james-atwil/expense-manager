import {createApp} from 'vue';
import {ScrollSpy} from "bootstrap";
import {Form} from "vee-validate";
import * as yup from "yup";

import TToasts from "../../../components/Toasts";
import TInput from "../../../components/Input/Text";
import TTextarea from "../../../components/Input/Textarea";
import TButton from "../../../components/Button";

import ServiceError from "../../../services/errors";
import {SettingsService} from "../../../services/system/service";

const IndexComponent = {
    components: {
        TToasts,
        VForm: Form,
        TInput,
        TTextarea,
        TButton
    },
    data() {
        return {
            service: null,
            submitting: false,
            settings: {},
            schema: yup.object({
                'site-meta-name': yup.string().required('Field is required.'),
                'site-meta-title': yup.string().required('Field is required.'),
                'admin-meta-name': yup.string().required('Field is required.'),
                'admin-meta-title': yup.string().required('Field is required.'),
                'profile-name': yup.string().required('Field is required.')
            })
        }

    },
    methods: {
        scrollIntoView: function (event) {
            event.preventDefault()
            const href = event.target.getAttribute('href');
            const el = href ? document.querySelector(href) : null;
            if (el) {
                window.scroll({
                    top: el.offsetTop + 49,
                    left: 0,
                    behavior: 'smooth'
                })
            }
        },
        async saveSettings() {
            this.submitting = true;
            let result = await this.service.save(this.settings)
            this.submitting = false;

            if (result instanceof ServiceError) {
                this.$refs.toasts.post('danger', result.message)
            } else {
                this.$refs.toasts.post('success', 'Settings has been saved.')
            }
        },
    },
    created() {
        this.service = new SettingsService();
    },
    async mounted() {
        new ScrollSpy(document.body, {
            target: '#fmi',
            offset: 76
        });

        let result = await this.service.list();

        if (result instanceof ServiceError) {
            this.loading = false;
            this.$refs.toasts.post('danger', result.message)
            return;
        }

        this.settings = result.data;
    }
}

let app = createApp(IndexComponent)
app.mount('#module');
