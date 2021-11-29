<template>
  <div @click="shiftMode" :class="classItem">
    <i class="hidden text-yellow-400 fas fa-sun dark:block"></i>
    <i class="block text-gray-300 dark:hidden fas fa-moon"></i>
  </div>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
    props:{
        classItem : String
    },
    methods:{
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
    if (
      localStorage.theme == "dark" ||
      (!("theme" in localStorage) &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
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
