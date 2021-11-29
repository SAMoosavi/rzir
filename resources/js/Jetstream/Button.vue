<template>

    <button
      :type="type"
      class="bg-yellow-300 hover:bg-yellow-100 dark:bg-yellow-400 dark:hover:bg-yellow-600 dark:focus:bg-yellow-600 hover:shadow-lg "
      :class="classItem"
    >
      <slot></slot>
    </button>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: {
    type: {
      type: String,
      default: "submit",
    },
  },
});
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

