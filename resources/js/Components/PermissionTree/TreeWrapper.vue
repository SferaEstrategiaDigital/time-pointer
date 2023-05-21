<template>
    <div class="flex space-x-4 overflow-auto">
        <ul v-for="item in data" class="w-full">
            <nested-item
                :item="item"
                :checkedItems="checkedItems"
                @checkedItemUpdated="checkedItemUpdated"
                class="mr-4"
            ></nested-item>
        </ul>
    </div>
</template>

<script setup>
import { ref } from "vue";
import NestedItem from "./NestedItem.vue";

const checkedItems = ref([]);

defineProps({ data: Object, modelValue: Array });
const emit = defineEmits(["update:modelValue"]);
const checkedItemUpdated = ($event) => {
    checkedItems.value = $event;
    emit("update:modelValue", $event);
};
</script>
