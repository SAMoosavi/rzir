<template>
  <div>
    <div v-if="userPermissions.canAddTeamMembers">
      <jet-section-border />

      <!-- Add Team Member -->
      <jet-form-section @submitted="addTeamMember">
        <template #title> افزودن عضو </template>

        <template #description>
          عضوی جدید از گروه را به گروه خود اضافه کنید و به وی اجازه دهید به وسایل لیست دسترسی داشته باشد
        </template>

        <template #form>
          <div class="col-span-6">
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
              لطفاً آدرس ایمیل شخصی را که می خواهید به این گروه اضافه کنید ،
              وارد کنید.
            </div>
          </div>

          <!-- Member Email -->
          <div class="col-span-6 sm:col-span-4">
            <jet-label for="email" value="ایمیل" />
            <jet-input
              id="email"
              type="email"
              classItem="block w-full mt-1 text-left"
              v-model="addTeamMemberForm.email"
            />
            <jet-input-error
              :message="addTeamMemberForm.errors.email"
              class="mt-2"
            />
          </div>
        </template>

        <template #actions>
          <jet-action-message
            :on="addTeamMemberForm.recentlySuccessful"
            class="ml-3"
          >
            افزوده شد.
          </jet-action-message>

          <jet-button
            :class="{ 'opacity-25': addTeamMemberForm.processing }"
            :disabled="addTeamMemberForm.processing"
          >
            افزودن
          </jet-button>
        </template>
      </jet-form-section>
    </div>

    <div
      v-if="
        team.team_invitations.length > 0 && userPermissions.canAddTeamMembers
      "
    >
      <jet-section-border />

      <!-- Team Member Invitations -->
      <jet-action-section class="mt-10 sm:mt-0">
        <template #title> دعوت‌نامه‌های گروه در انتظار </template>

        <template #description>
          این افراد به گروه شما دعوت شده اند و یک ایمیل دعوت برای آنها ارسال شده است. آنها ممکن است با پذیرش دعوتنامه به گروه ملحق شوند.
        </template>

        <!-- Pending Team Member Invitation List -->
        <template #content>
          <div class="space-y-6">
            <div
              class="flex items-center justify-between"
              v-for="invitation in team.team_invitations"
              :key="invitation.id"
            >
              <div class="text-gray-600 dark:text-gray-300">{{ invitation.email }}</div>

              <div class="flex items-center">
                <!-- Cancel Team Invitation -->
                <button
                  class="ml-6 text-lg text-red-500 cursor-pointer focus:outline-none dark:text-red-700"
                  @click="cancelTeamInvitation(invitation)"
                  v-if="userPermissions.canRemoveTeamMembers"
                >
                  لغو
                </button>
              </div>
            </div>
          </div>
        </template>
      </jet-action-section>
    </div>

    <div v-if="team.users.length > 0">
      <jet-section-border />

      <!-- Manage Team Members -->
      <jet-action-section class="mt-10 sm:mt-0">
        <template #title> اعضای گروه </template>

        <template #description>
          همه افرادی که در این گروه عضو هستند.
        </template>

        <!-- Team Member List -->
        <template #content>
          <div class="space-y-6">
            <div
              class="flex items-center justify-between"
              v-for="user in team.users"
              :key="user.id"
            >
              <div class="flex items-center">
                <img
                  class="w-8 h-8 rounded-full"
                  :src="user.profile_photo_url"
                  :alt="user.name"
                />
                <div class="mr-4">{{ user.name }}</div>
              </div>

              <div class="flex items-center">
                <!-- Leave Team -->
                <Jet-danger-button
                    class="mr-6 cursor-pointer"
                  @click="alertLeaveTeam"
                  v-if="$page.props.user.id === user.id"
                >
                  ترک کردن
                </Jet-danger-button>

                <!-- Remove Team Member -->
                <Jet-danger-button
                  class="mr-6 cursor-pointer"
                  @click="alertRemoveTeamMember(user)"
                  v-if="userPermissions.canRemoveTeamMembers"
                >
                  حذف کردن
                </Jet-danger-button>
              </div>
            </div>
          </div>
        </template>
      </jet-action-section>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue"
import JetConfirmationModal from "@/Jetstream/ConfirmationModal.vue";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import Swal from "sweetalert2";

export default defineComponent({
  components: {
    JetActionMessage,
    JetActionSection,
    JetButton,
    JetDangerButton,
    JetConfirmationModal,
    JetDialogModal,
    JetFormSection,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    JetSectionBorder,
    Swal,
  },

  props: ["team", "availableRoles", "userPermissions"],

  data() {
    return {
      addTeamMemberForm: this.$inertia.form({
        email: "",
        role: 'editor',
      }),

      updateRoleForm: this.$inertia.form({
        role: null,
      }),

      leaveTeamForm: this.$inertia.form(),
      removeTeamMemberForm: this.$inertia.form(),

      currentlyManagingRole: false,
      managingRoleFor: null,
      confirmingLeavingTeam: false,
      teamMemberBeingRemoved: null,
    };
  },

  methods: {
    addTeamMember() {
      this.addTeamMemberForm.post(route("team-members.store", this.team), {
        errorBag: "addTeamMember",
        preserveScroll: true,
        onSuccess: () => this.addTeamMemberForm.reset(),
      });
    },

    cancelTeamInvitation(invitation) {
      this.$inertia.delete(route("team-invitations.destroy", invitation), {
        preserveScroll: true,
      });
    },

    manageRole(teamMember) {
      this.managingRoleFor = teamMember;
      this.updateRoleForm.role = teamMember.membership.role;
      this.currentlyManagingRole = true;
    },

    updateRole() {
      this.updateRoleForm.put(
        route("team-members.update", [this.team, this.managingRoleFor]),
        {
          preserveScroll: true,
          onSuccess: () => (this.currentlyManagingRole = false),
        }
      );
    },

    confirmLeavingTeam() {
      this.confirmingLeavingTeam = true;
    },

    alertLeaveTeam(){
        Swal.fire({
        title: "توجه!",
        icon: "warning",
        text: ' آیا مطمئن هستید که می خواهید این گروه را ترک کنید؟',
        showCancelButton: true,
        confirmButtonText: "حذف",
        cancelButtonText: "لغو",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6e7d88",
        preConfirm: () => {
          return this.leaveTeam();
        },
      });
    },

    leaveTeam() {
      this.leaveTeamForm.delete(
        route("team-members.destroy", [this.team, this.$page.props.user])
      );
    },

    confirmTeamMemberRemoval(teamMember) {
      this.teamMemberBeingRemoved = teamMember;
    },

alertRemoveTeamMember(teamMember){
    this.teamMemberBeingRemoved = teamMember;
    Swal.fire({
        title: "توجه!",
        icon: "warning",
        text: 'آیا مطمئن هستید که می خواهید این فرد را از گروه حذف کنید؟',
        showCancelButton: true,
        confirmButtonText: "حذف",
        cancelButtonText: "لغو",
        showLoaderOnConfirm: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6e7d88",
        preConfirm: () => {
          return this.removeTeamMember();
        },
      });
},
    removeTeamMember() {
      this.removeTeamMemberForm.delete(
        route("team-members.destroy", [this.team, this.teamMemberBeingRemoved]),
        {
          errorBag: "removeTeamMember",
          preserveScroll: true,
          preserveState: true,
          onSuccess: () => (this.teamMemberBeingRemoved = null),
        }
      );
    },

    displayableRole(role) {
      return this.availableRoles.find((r) => r.key === role).name;
    },
  },
});
</script>
