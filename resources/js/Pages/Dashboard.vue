<template>
    <app-layout title="وسایل">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                وسایل
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <ul>
                        <li v-for="device in devices" :key="device.id">
                            {{device.name}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent, reactive } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'

    export default defineComponent({
        components: {
            AppLayout,
        },
        props:{
            devices:Object,
        },
        setup(props){
            const devices = reactive(props.devices);

            return {
                devices
            }
        }
    })
</script>
