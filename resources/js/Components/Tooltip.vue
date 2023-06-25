<template>
    <div
        class="relative group"
        ref="tooltipContainer"
        @click="toggleTooltip"
        @mouseenter="hoverTooltip"
        @mouseleave="leaveTooltip"
    >
        <button ref="tooltipTrigger"><slot name="title"></slot></button>
        <div
            ref="tooltipContent"
            class="absolute left-0 w-full transition ease-in-out duration-200"
            style="top: 100%"
            :class="{ hidden: !tooltipVisible }"
        >
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const tooltipContainer = ref(null);
const tooltipTrigger = ref(null);
const tooltipContent = ref(null);
const tooltipVisible = ref(false);
const props = defineProps({
    clickToShow: {
        type: Boolean,
        default: false,
    },
});

onMounted(() => {
    document.addEventListener("click", outsideClickListener);
});

onUnmounted(() => {
    document.removeEventListener("click", outsideClickListener);
});

function toggleTooltip(event) {
    if (props.clickToShow && !tooltipContent.value.contains(event.target)) {
        tooltipVisible.value = !tooltipVisible.value;
    }
}

function hoverTooltip() {
    if (!props.clickToShow) {
        tooltipVisible.value = true;
    }
}

function leaveTooltip() {
    if (!props.clickToShow) {
        tooltipVisible.value = false;
    }
}

function outsideClickListener(event) {
    if (
        !tooltipContainer.value.contains(event.target) &&
        !tooltipContent.value.contains(event.target)
    ) {
        tooltipVisible.value = false;
    }
}
</script>
