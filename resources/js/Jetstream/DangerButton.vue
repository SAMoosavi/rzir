<template>
    <button :type="type" class="inline-flex items-center text-xs tracking-widest text-gray-700 uppercase transition bg-red-500 rounded-md shadow-sm hover:shadow-lg active:text-gray-800 active:bg-yellow-50 disabled:opacity-25 hover:bg-red-400 dark:bg-red-600 dark:hover:bg-red-800">
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: {
            type: {
                type: String,
                default: 'button',
            },
        }
    })
</script>
<style scoped>

button {
  letter-spacing: -0.2px;
  font-size: 16px;
}

button {
  border: 0;
  outline: 0;
  font-size: 16px;
  border-radius: 29px;
  padding: 16px;
}

button {
  font-weight: bold;
  transition: all 0.2s ease-in-out;
  cursor: pointer;
  font-weight: 600;
}

</style>
