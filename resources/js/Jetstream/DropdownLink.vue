<template>
    <div>
        <button type="submit" class="block w-full px-4 py-2 text-sm leading-5 text-left text-gray-700 transition hover:bg-indigo-50 focus:outline-none focus:bg-indigo-50 dark:text-gray-100 dark:hover:bg-indigo-600" v-if="as == 'button'">
            <slot></slot>
        </button>

        <a :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 transition hover:bg-indigo-50 focus:outline-none focus:bg-indigo-50 dark:text-gray-100 dark:hover:bg-indigo-600" v-else-if="as =='a'">
            <slot></slot>
        </a>

        <Link :href="href" class="block px-4 py-2 text-sm leading-5 text-gray-700 transition hover:bg-indigo-50 focus:outline-none focus:bg-indigo-50 dark:text-gray-100 dark:hover:bg-indigo-600" v-else>
            <slot></slot>
        </Link>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'as']
    })
</script>
