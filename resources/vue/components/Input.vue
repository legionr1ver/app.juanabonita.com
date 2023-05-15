<script>
export default {
  props: {
    modelValue: {
      type: String,
      required: true,
    },
  },
  emits: [
    'update:modelValue'
  ],
}
</script>

<template>
  <input :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="p-2 border border-solid border-outline rounded-md text-outline">
</template>

<style></style>