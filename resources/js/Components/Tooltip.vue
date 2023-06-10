<template>
    <div class="relative group">
        <button><slot name="title"></slot></button>
        <div
            class="absolute left-0 hidden group-hover:block transition ease-in-out duration-200"
            style="top: 100%"
        >
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script setup></script>
