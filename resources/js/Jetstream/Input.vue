<template>
  <label>
    <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      ref="input"
      :id="id"
      :type="type"
      :class="classItem"
    />
  </label>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  props: ["modelValue","id","type","classItem"],

  emits: ["update:modelValue"],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
});
</script>

<style scoped>

input {

  letter-spacing: -0.2px;
  font-size: 16px;
}

input {
  border: 0;
  outline: 0;
  font-size: 16px;
  border-radius: 320px;
  padding: 16px;
}

label {
  display: block;
  margin-bottom: 24px;
  width: 100%;
}

input {
  margin-right: 8px;
  width: 100%;
  box-sizing: border-box;
  transition: all 0.2s ease-in-out;
  appearance: none;
  -webkit-appearance: none;
}


</style>
