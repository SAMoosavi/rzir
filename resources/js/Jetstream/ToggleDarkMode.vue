<template>
  <div @click="shiftMode" :class="classItem">
    <i class="hidden text-yellow-400 fas fa-sun dark:block dark:hover:text-yellow-100"></i>
    <i class="block text-gray-700 dark:hidden fas fa-moon hover:text-gray-800"></i>
  </div>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
  props: {
    classItem: String,
  },
  methods: {
    shiftMode() {
      if (localStorage.getItem("them") == "dark") {
        localStorage.setItem("them", "light");
        document.getElementById("html").classList.remove("dark");
      } else {
        document.getElementById("html").classList.add("dark");
        localStorage.setItem("them", "dark");
      }
    },
  },
  mounted() {
    if (localStorage.them == "dark") {
      document.getElementById("html").classList.add("dark");
      localStorage.setItem("them", "dark");
    } else {
      document.getElementById("html").classList.remove("dark");
      localStorage.setItem("them", "light");
    }
  },
});
</script>

<style>
</style>
