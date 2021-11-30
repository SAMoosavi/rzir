<template>
    <button :type="type" class="inline-flex items-center text-xs tracking-widest text-gray-700 uppercase transition bg-yellow-300 rounded-md shadow-sm hover:bg-yellow-100 dark:bg-yellow-400 dark:hover:bg-yellow-600 dark:focus:bg-yellow-600 hover:shadow-lg active:text-gray-800 active:bg-yellow-50 disabled:opacity-25">
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
