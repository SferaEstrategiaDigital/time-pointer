<template>
    <input type="text" :placeholder="placeholder" v-model="inputValue" />
</template>

<script setup>
import { ref, watch, defineProps } from "vue";

const props = defineProps({
    placeholder: {
        type: String,
        default: "",
    },
});

let inputValue = ref("");

watch(inputValue, (newVal, oldVal) => {
    let regex = /^\d*,?\d*$/;
    if (!regex.test(newVal) || (newVal.match(/,/g) || []).length > 1) {
        inputValue.value = oldVal;
    }
});
</script>
