<script setup>
import HeaderComponent from '@/components/HeaderComponent.vue'
</script>

<template>
    <div class="flex-1 max-w-[1680px]">
        <HeaderComponent />
        <slot />
    </div>
</template>