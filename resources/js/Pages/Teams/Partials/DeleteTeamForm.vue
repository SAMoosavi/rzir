<template>
    <jet-action-section>
        <template #title>
            حذف گروه
        </template>

        <template #description>
            این گروه را برای همیشه حذف می شود.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                پس از حذف یک گروه، تمام منابع و داده های آن برای همیشه حذف می شوند. قبل از حذف این گروه، لطفاً هر گونه داده یا اطلاعات مربوط به این گروه را که می‌خواهید حفظ کنید، دانلود کنید.
            </div>

            <div class="mt-5">
                <jet-danger-button @click="confirmTeamDeletion">
                    حذف گروه،
                </jet-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <jet-confirmation-modal :show="confirmingTeamDeletion" @close="confirmingTeamDeletion = false">
                <template #title>
                    حذف گروه.
                </template>

                <template #content>
                    آیا مطمئنید که می خواهید این گروه را حذف کنید؟ پس از حذف یک گروه، تمام منابع و داده های آن برای همیشه حذف می شوند.
                </template>

                <template #footer>
                    <jet-secondary-button @click="confirmingTeamDeletion = false">
                        لغو
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click="deleteTeam" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        حذف گروه،
                    </jet-danger-button>
                </template>
            </jet-confirmation-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetActionSection from '@/Jetstream/ActionSection.vue'
    import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

    export default defineComponent({
        props: ['team'],

        components: {
            JetActionSection,
            JetConfirmationModal,
            JetDangerButton,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingTeamDeletion: false,
                deleting: false,

                form: this.$inertia.form()
            }
        },

        methods: {
            confirmTeamDeletion() {
                this.confirmingTeamDeletion = true
            },

            deleteTeam() {
                this.form.delete(route('teams.destroy', this.team), {
                    errorBag: 'deleteTeam'
                });
            },
        },
    })
</script>
