<template>
  <jet-action-section>
    <template #title> حذف حساب کاربری </template>

    <template #description> حذف دائمی حساب کاربری </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        پس از حذف حساب شما، تمام منابع و داده های آن برای همیشه حذف می شوند.
      </div>

      <div class="mt-5">
        <jet-danger-button @click="alertDeleteUser">
          حذف حساب کاربری
        </jet-danger-button>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
        <template #title> حذف حساب کاربری </template>

        <template #content>
          آیا مطمئن هستید که می خواهید اکانت خود را حذف کنید؟ پس از حذف حساب
          شما، تمام منابع و داده های آن برای همیشه حذف می شوند. لطفاً رمز عبور
          خود را وارد کنید تا تأیید کنید که می خواهید حساب خود را برای همیشه حذف
          کنید.
          <div class="mt-4">
            <jet-input
              type="password"
              class="block w-3/4 mt-1"
              placeholder="رمز عبور"
              ref="password"
              v-model="form.password"
              @keyup.enter="deleteUser"
            />

            <jet-input-error :message="form.errors.password" class="mt-2" />
          </div>
        </template>

        <template #footer>
          <jet-secondary-button @click="closeModal"> لغو </jet-secondary-button>

          <jet-danger-button
            class="ml-2"
            @click="deleteUser"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            حذف حساب کاربری
          </jet-danger-button>
        </template>
      </jet-dialog-modal>
    </template>
  </jet-action-section>
</template>

<script>
import { defineComponent } from "vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import Swal from "sweetalert2";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

export default defineComponent({
  components: {
    JetActionSection,
    JetDangerButton,
    JetDialogModal,
    JetInput,
    JetInputError,
    JetSecondaryButton,
  },

  data() {
    return {
      confirmingUserDeletion: false,

      form: this.$inertia.form({
        password: "",
      }),
    };
  },

  methods: {
    alertDeleteUser() {
      Swal.fire({
        customClass: {
          text: "text-justify text-red-500",
          title: " text-red-900 ",
        },
        title: "رمز خود را وارد کنید",
        text: " آیا مطمئن هستید که می خواهید اکانت خود را حذف کنید؟ پس از حذف حساب شما، تمام منابع و داده های آن برای همیشه حذف می شوند. لطفاً رمز عبور خود را وارد کنید تا تأیید کنید که می خواهید حساب خود را برای همیشه حذف کنید.",
        input: "password",
        inputAttributes: {
          autocapitalize: "off",
        },
        showCancelButton: true,
        confirmButtonText: "حذف",
        cancelButtonText: "لغو",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6e7d88",
        preConfirm: (name) => {
          return this.deleteUser(name);
        },
        allowOutsideClick: () => !Swal.isLoading(),
      });
    },

    deleteUser() {
      this.form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => {
          Swal.fire({
            icon: "error",
            title: "خطاا!!!",
            text: "رمز وارد شده اشتباه است !",
            showConfirmButton: true,
            showCancelButton: true,
            cancelButtonText: "باشد",
            confirmButtonText: "برگشت",
            preConfirm: () => {
              return this.alertDeleteUser();
            },
          });
        },
        onFinish: () => this.form.reset(),
      });
    },

    closeModal() {
      this.confirmingUserDeletion = false;

      this.form.reset();
    },
  },
});
</script>
