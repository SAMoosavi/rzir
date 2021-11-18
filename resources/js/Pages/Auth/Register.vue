<template>
    <Head title="ثبتنام" />

    <jet-authentication-card>
        <template #image>
      <img :src="'../image/register.png'" class="h-screen p-0 m-0" alt="تصویر صفحه ثبتنام" />
    </template>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="نام" />
                <jet-input id="name" type="text" class="block w-full mt-1" v-model="form.name"  autocomplete="name" />
            </div>

            <div class="mt-4">
                <jet-label for="email" value="ایمیل" />
                <jet-input id="email" type="email" class="block w-full mt-1 text-left" v-model="form.email"  />
            </div>

            <div class="mt-4">
                <jet-label for="password" value="رمز عبور" />
                <jet-input id="password" type="password" class="block w-full mt-1 text-left" v-model="form.password"  autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <jet-label for="password_confirmation" value="تکرار رمز عبور" />
                <jet-input id="password_confirmation" type="password" class="block w-full mt-1 text-left" v-model="form.password_confirmation"  autocomplete="new-password" />
            </div>

            <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                <jet-label for="terms">
                    <div class="flex items-center">
                        <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                        <div class="ml-2">
                            من موافقم <a target="_blank" :href="route('terms.show')" class="text-sm text-gray-600 underline hover:text-gray-900">شرایط استفاده از خدمات</a> and <a target="_blank" :href="route('policy.show')" class="text-sm text-gray-600 underline hover:text-gray-900">سیاست حفظ حریم خصوصی</a>
                        </div>
                    </div>
                </jet-label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="ml-auto text-sm text-gray-500 underline hover:text-black">
                    قبلا ثبت نام کرده ام
                </Link>

                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    ثبتنام
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    })
</script>
