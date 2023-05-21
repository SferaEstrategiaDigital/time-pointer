<template>
    <div class="flex space-x-4 overflow-auto">
        <ul v-for="item in data" class="w-full">
            <nested-item
                :item="item"
                :checkedItems="checkedItems"
                @checkedItemUpdated="checkedItems = $event"
                class="mr-4"
            ></nested-item>
        </ul>
    </div>
</template>

<script setup>
import { ref } from "vue";
import NestedItem from "./NestedItem.vue";
defineProps({ data: Object });
const checkedItems = ref([]);
</script>
