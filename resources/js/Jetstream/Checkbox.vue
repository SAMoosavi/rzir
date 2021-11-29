<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
           class="text-yellow-300 border-gray-300 rounded shadow-sm focus:border-none focus:ring-gray-100 focus:ring-opacity-50 dark:text-yellow-400 dark:focus:ring-gray-600 dark:border-gray-600">
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
    },

    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
})
</script>
