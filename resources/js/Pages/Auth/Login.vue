<template>
  <Head title="ورود" />

  <jet-authentication-card>
    <template #image>
      <img
        :src="'../image/login.png'"
        class="h-screen p-0 m-0"
        alt="تصویر صفحه ورود"
      />
    </template>

    <jet-validation-errors class="mb-4" />

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <jet-label for="email" value="ایمیل" />
        <jet-input
          id="email"
          type="email"
          classItem="block w-full mt-1 text-left"
          v-model="form.email"
        />
      </div>

      <div class="mt-4">
        <jet-label for="password" value="رمز عبور" />
        <jet-input
          id="password"
          type="password"
          classItem="block w-full mt-1 text-left"
          v-model="form.password"
          autocomplete="current-password"
        />
      </div>

      <div class="block mt-4">
        <label class="flex items-center">
          <jet-checkbox name="remember" @checked="form.remember" />
          <span class="mx-2 text-sm text-gray-800 dark:text-white">من را به خاطر بسپار</span>
        </label>
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="ml-auto text-sm text-gray-500 underline hover:text-black dark:text-gray-400 dark:hover:text-white"
        >
          رمز عبور خود را فراموش کرده اید؟
        </Link>

        <jet-button
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          ورود
        </jet-button>
      </div>
      <div>
        <Link
          :href="route('register')"
          class="text-sm text-gray-500 underline hover:text-black dark:text-gray-400 dark:hover:text-white"
        >
          ساخت حساب جدید
        </Link>
      </div>
       <hr class="my-3">
        <div>
            <Login-google/>
      </div>
    </form>
  </jet-authentication-card>
</template>

<script>
import { defineComponent } from "vue";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import LoginGoogle from "@/Jetstream/LoginGoogle.vue"

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
    LoginGoogle,
  },

  props: {
    canResetPassword: Boolean,
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
        password: "",
        remember: false,
      }),
    };
  },

  methods: {
    submit() {
      this.form
        .transform((data) => ({
          ...data,
          remember: this.form.remember ? "on" : "",
        }))
        .post(this.route("login"), {
          onFinish: () => this.form.reset("password"),
        });
    },
  },
});
</script>
