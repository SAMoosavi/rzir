<template>
  <button
    class="text-white bg-red-500 hover:bg-red-300 hover:text-gray-700 active:bg-red-900 hover:shadow-lg dark:bg-red-700 dark:hover:bg-red-900 dark:hover:text-gray-200"
    type="button"
  >
    <Link :href="route('social.oauth', 'google')"> ورود با حساب گوگل </Link>
  </button>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
  components: {
    Link,
  },
};
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
