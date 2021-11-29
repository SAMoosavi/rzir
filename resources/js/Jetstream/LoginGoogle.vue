<template>
  <button
    class="inline-flex items-center px-4 py-2 text-xs tracking-widest text-white uppercase transition bg-red-700 border border-transparent rounded-md  hover:bg-red-300 hover:text-gray-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring focus:ring-red-300 disabled:opacity-25"
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
