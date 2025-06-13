<script setup>
import { ref } from 'vue'
import close from '@/assets/images/icons/close.svg'

const isOpen = ref(false)
const toggle = () => {
    isOpen.value = !isOpen.value
}
defineProps({
    cargo: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <td class="px-6 py-2 whitespace-nowrap text-sm">
        <p>{{ cargo.weight_tons }}т. {{ cargo.volume_m3 }}м, Отдельная машина</p>
        <div class="relative">
            <button @click="toggle"
                class="text-accent pb-px border-b z-10 border-transparent hover:border-accent transition-all duration-500 ease-in-out cursor-pointer">Показать
                больше</button>
            <transition name="slide-fade">
                <div v-if="isOpen"
                    class="flex-col justify-center items-start gap-1 absolute top-0.5 left-0 w-auto bg-light pl-1 pt-8 pb-3 pr-3 shadow-lg shadow-black/15 z-10 rounded-md transition-all duration-300 ease-in-out overflow-hidden">
                    <img @click="toggle" class="size-6 cursor-pointer absolute top-2 right-2" :src="close"
                        alt="close" />
                    <p class="text-dark-blue text-xs font-normal">Тип перевозки: {{ cargo.body_type }}</p>
                    <p class="text-light-gray text-xs">Тип загрузки: {{ cargo.loading_type }}</p>
                    <p class="text-light-gray text-xs">Доп. информация:</p>
                    <p class="text-light-gray text-xs whitespace-normal">{{ cargo.additional_info }}</p>
                </div>
            </transition>
        </div>
    </td>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
