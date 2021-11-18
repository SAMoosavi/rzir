<template>
    <Head title="تایید ایمیل" />

    <jet-authentication-card>
        <template #image>
      <img
        :src="'../image/verify-email.png'"
        class="h-screen p-0 m-0"
        alt="تصویر صفحه تایید ایمیل"
      />
    </template>

        <div class="mb-4 text-sm text-gray-600">
            از ثبت نام شما سپاسگزاریم! قبل از شروع، آیا می توانید آدرس ایمیل خود را با کلیک کردن روی پیوندی که به تازگی برای شما ایمیل کرده ایم تأیید کنید؟ اگر ایمیلی را دریافت نکردید، با کمال میل یک ایمیل دیگر برای شما ارسال خواهیم کرد.
        </div>

        <div class="mb-4 text-sm font-medium text-green-600" v-if="verificationLinkSent" >
           یک پیوند تأیید جدید به آدرس ایمیلی که هنگام ثبت نام ارائه کرده اید ارسال شده است.
        </div>

        <form @submit.prevent="submit">
            <div class="flex items-center justify-between mt-4">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                   ایمیل تایید را دوباره بفرست
                </jet-button>

                <!-- <Link :href="route('logout')" method="post" as="button" class="text-sm text-gray-600 underline hover:text-gray-900">Log Out</Link> -->
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            Link,
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form()
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('verification.send'))
            },
        },

        computed: {
            verificationLinkSent() {
                return this.status === 'verification-link-sent';
            }
        }
    })
</script>
