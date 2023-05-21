<template>
    <li>
        <div class="p-2">
            <input
                type="checkbox"
                class="cursor-pointer outline-none focus:outline-none"
                :id="item.caminho"
            />
            <label :for="item.caminho" class="ml-2 cursor-pointer">{{
                item.name
            }}</label>
        </div>
        <ul v-if="item.sub && item.sub.length">
            <nested-item
                v-for="i in item.sub"
                :item="i"
                class="pl-4"
            ></nested-item>
            <!-- <li>{{  }}</li> -->
        </ul>
    </li>
</template>

<script setup>
import NestedItem from "./NestedItem.vue";
defineProps({ item: Object });
</script>

<style scoped></style>
