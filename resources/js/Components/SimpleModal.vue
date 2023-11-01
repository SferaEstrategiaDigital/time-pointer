<template>
    <slot name="trigger"></slot>

    <div
        v-if="isOpen"
        class="fixed top-0 left-0 w-full h-full flex justify-center items-center z-10"
    >
        <div
            class="absolute w-full h-full bg-black/5 backdrop-blur-[1px]"
            @click="close"
        ></div>
        <div
            class="relative bg-white p-4 place-items-center shadow-lg rounded-xl overflow-auto w-3/4 h-3/4"
        >
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, watchEffect } from "vue";

const emit = defineEmits(["close"]);
const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
});
const close = () => {
    emit("close");
};

watchEffect(() => {
    if (props.isOpen) {
        document.body.style.overflow = "hidden";
    } else {
        document.body.style.overflow = "auto";
    }
});
</script>
