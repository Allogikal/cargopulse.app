<script setup>
import { ref } from 'vue'
// IMAGES
import placeholder from '@/assets/images/placeholder.webp'
import closeWhite from '@/assets/images/icons/close_white.svg'
import Swal from 'sweetalert2'

const emit = defineEmits(['close', 'submit'])
defineProps(['unassignedUsers'])
const selectedUser = ref(null)

const submitForm = () => {
    if (!selectedUser.value) {
        Swal.fire({
            position: "top-end",
            icon: "error",
            title: "Выберите сотрудника!",
            showConfirmButton: false,
            timer: 2000
        });
        return
    }
    emit('submit', selectedUser.value)
}
</script>

<template>
    <div class="fixed inset-0 bg-black/75 items-center justify-center flex z-50 transition-opacity duration-500"
        :class="{ 'opacity-100': true, 'opacity-0': false }" @click.self="$emit('close')">
        <transition name="modal">
            <div class="bg-white rounded-2xl shadow-2xl shadow-black/50 h-auto items-center w-1/4 max-sm:w-3/4 transform scale-95 opacity-0 transition-all duration-500 relative flex flex-col"
                :class="{ 'scale-100 opacity-100': true }">
                <div class="flex w-full justify-between items-center p-4 bg-dark-blue rounded-t-2xl">
                    <p class="text-[#EAEAEA] text-xs uppercase font-semibold tracking-wider">Добавить сотрудника</p>
                    <button @click="$emit('close')"
                        class="text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer">
                        <img :src="closeWhite" alt="close" /> </button>
                </div>
                <form @submit.prevent="submitForm"
                    class="flex gap-4 justify-center justify-items-center max-lg:overflow-auto items-center p-6">
                    <div class="flex flex-col h-auto items-center justify-center w-full">
                        <div class="flex gap-4 flex-wrap">
                            <label v-for="user in unassignedUsers" :key="user.id"
                                class="group flex justify-center items-center relative cursor-pointer border-2 border-gray-300 hover:border-accent rounded-full p-2 transition-all duration-300"
                                :class="{ 'ring-2 ring-accent': selectedUser === user.id }">
                                <input type="radio" v-model="selectedUser" :value="user.id" class="hidden" />
                                <img :src="user.avatar ? '/storage/' + user.avatar : placeholder" alt="avatar"
                                    class="size-12 rounded-full object-center object-cover group-hover:brightness-100 brightness-25 transition-all ease-in-out duration-500" />
                                <p
                                    class="absolute text-lg group-hover:opacity-0 transition-all duration-500 ease-in-out text-white">
                                    {{ user.name.charAt(0).toUpperCase() }}{{ user.surname.charAt(0).toUpperCase() }}
                                </p>
                            </label>
                            <p class="text-accent font-semibold" v-if="unassignedUsers.length === 0">Нет доступных
                                сотрудников.</p>
                        </div>
                        <div class="flex justify-center items-center w-full pt-12">
                            <button type="submit"
                                class="w-auto px-6 py-3 text-xs text-white bg-accent rounded-full text-center whitespace-nowrap cursor-pointer">Добавить
                                сотрудника</button>
                        </div>
                    </div>
                </form>
            </div>
        </transition>
    </div>
</template>