<template>
    <Head title="منطقه امن" />

    <jet-authentication-card>
        <template #image>
      <img
        :src="'../image/confirm-password.png'"
        class="h-screen p-0 m-0"
        alt="تصویر صفحه منطقه امن"
      />
    </template>

        <div class="mb-4 text-sm text-gray-600 dark:text-white">
            این یک منطقه امن برنامه است. لطفاً قبل از ادامه رمز عبور خود را تأیید کنید.
        </div>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="password" value="رمز عبور" />
                <jet-input id="password" type="password" class="block w-full mt-1 text-left" v-model="form.password" required autocomplete="current-password" autofocus />
            </div>

            <div class="flex justify-end mt-4">
                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        تایید
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue';
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

        data() {
            return {
                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.confirm'), {
                    onFinish: () => this.form.reset(),
                })
            }
        }
    })
</script>
