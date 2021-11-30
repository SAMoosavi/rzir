<template>
    <jet-form-section @submitted="updateTeamName">
        <template #title>
            نام گروه
        </template>

        <template #description>
            نام گروه و مشخصات سازنده گروه.
        </template>

        <template #form>
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <jet-label value="سازنده گروه" />

                <div class="flex items-center mt-2">
                    <img class="object-cover w-12 h-12 rounded-full" :src="team.owner.profile_photo_url" :alt="team.owner.name">

                    <div class="mr-4 leading-tight">
                        <div class="dark:text-gray-200">{{ team.owner.name }}</div>
                        <div class="text-sm text-gray-700 dark:text-gray-400">{{ team.owner.email }}</div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="نام گروه" />

                <jet-input id="name"
                            type="text"
                            classItem="block w-full mt-1"
                            v-model="form.name"
                            :disabled="! permissions.canUpdateTeam" />

                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="permissions.canUpdateTeam">
            <jet-action-message :on="form.recentlySuccessful" class="ml-3">
                ذخیره شد.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                ذخیره
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'

    export default defineComponent({
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        props: ['team', 'permissions'],

        data() {
            return {
                form: this.$inertia.form({
                    name: this.team.name,
                })
            }
        },

        methods: {
            updateTeamName() {
                this.form.put(route('teams.update', this.team), {
                    errorBag: 'updateTeamName',
                    preserveScroll: true
                });
            },
        },
    })
</script>
