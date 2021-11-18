<template>
    <Head title="فراموش رمز عبور" />

    <jet-authentication-card>
        <template #image>
            <img :src="'../image/Forgot-Password.png'" alt="تصویر صفحه فراموشی رمز ورود" class="h-screen p-0 m-0">
        </template>

        <jet-validation-errors class="mb-4" />
        
        <div class="mb-4 text-lg text-justify text-gray-600">
            رمز عبور خود را فراموش کرده اید؟ مشکلی نیست فقط آدرس ایمیل خود را به ما اطلاع دهید و ما یک پیوند بازنشانی رمز عبور را برای شما ایمیل می کنیم که به شما امکان می دهد رمز جدیدی را انتخاب کنید.       </div>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>


        <form @submit.prevent="submit">
            <div>
                <jet-label for="email" value="ایمیل" />
                <jet-input id="email" type="email" class="block w-full mt-1" v-model="form.email" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  ایمیل بازیابی رمز عبور
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head } from '@inertiajs/inertia-vue3';
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    })
</script>
