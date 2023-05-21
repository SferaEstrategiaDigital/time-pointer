<template>
    <li>
        <div class="p-2">
            <input
                type="checkbox"
                class="cursor-pointer outline-none focus:outline-none"
                :id="item.caminho"
                :value="item.id"
                @change="updateChecked($event, item.id)"
                :checked="checkedItems.includes(item.id)"
            />
            <label :for="item.caminho" class="ml-2 cursor-pointer">{{
                item.name
            }}</label>
        </div>
        <ul v-if="item.sub && item.sub.length">
            <nested-item
                v-for="i in item.sub"
                :item="i"
                :items="item.sub"
                :checkedItems="checkedItems"
                @checkedItemUpdated="$emit('checkedItemUpdated', $event)"
                class="pl-4"
            ></nested-item>
        </ul>
    </li>
</template>

<script setup>
import NestedItem from "./NestedItem.vue";
const props = defineProps({
    item: Object,
    checkedItems: { type: Array, required: true },
});
const emit = defineEmits(["checkedItemUpdated"]);

const updateChecked = (event, id) => {
    if (event.target.checked) {
        props.checkedItems.push(id);
    } else {
        const index = props.checkedItems.indexOf(id);
        if (index !== -1) {
            props.checkedItems.splice(index, 1);
        }
    }
    emit("checkedItemUpdated", props.checkedItems);
};
</script>

<style scoped></style>
