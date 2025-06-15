<script setup>
import { onMounted, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

// IMAGES
import closeWhite from '@/assets/images/icons/close_white.svg'
import editForm from '@/assets/images/icons/edit_form.svg'

const emit = defineEmits(['close', 'submit'])
const user = computed(() => usePage().props.auth.user)
defineProps(['isTransportModalOpen'])

const form = useForm({
    user_id: user.value.id,
    number: '',
    brand: '',
    year: null,
    loading_type: '',
    body_type: ''
});

const submitForm = () => {
    const componentEmit = emit;

    form.post(route('transport.store'), {
        preserveScroll: true,
        onSuccess: () => {
            componentEmit('close');
            clearForm();
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Добавлен новый вид транспорта",
                showConfirmButton: false,
                timer: 1500
            });
        },
        onError: (e) => {
            console.log(e)
        }
    });
}

const clearForm = () => {
    form.reset();
}

const saveFormToLocalStorage = () => {
    localStorage.setItem('transportFormData', JSON.stringify(formData));
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Форма сохранена как черновик",
        showConfirmButton: false,
        timer: 1500
    });
}
onMounted(() => {
    const savedData = localStorage.getItem('transportFormData');
    if (savedData) {
        const parsedData = JSON.parse(savedData);
        for (const key in formData) {
            if (parsedData.hasOwnProperty(key)) {
                formData[key] = parsedData[key];
            }
        }
    }
});
</script>

<template>
    <teleport to="body">
        <div class="fixed bg-black/75 items-center justify-center flex inset-0 z-[9999] w-screen min-h-dvh"
            @click.self="$emit('close')">
            <transition name="modal">
                <div v-show="isTransportModalOpen"
                    class="bg-white z-[10000] rounded-2xl shadow-2xl shadow-black/50 max-w-1/3 max-lg:max-w-[90%] min-h-[90dvh] max-lg:min-h-auto w-full transform scale-95 opacity-0 transition-all duration-500 relative flex flex-col"
                    :class="{ 'scale-100 opacity-100': true }">
                    <div class="flex w-full justify-between items-center p-4 bg-dark-blue rounded-t-2xl">
                        <p class="text-[#EAEAEA] text-xs uppercase font-semibold tracking-wider">Добавить транспорт</p>
                        <button @click="$emit('close')"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer">
                            <img :src="closeWhite" alt="closeWhite" />
                        </button>
                    </div>

                    <div class="flex gap-4 justify-center items-center p-6 max-lg:overflow-scroll">
                        <form @submit.prevent="submitForm"
                            class="flex flex-col gap-3 h-auto items-start justify-start w-full">
                            <p class="text-xs uppercase font-normal tracking-wider">Новый транспорт</p>

                            <div class="flex flex-col justify-end gap-2 w-full">
                                <p>Номер транспорта <sup class="text-red-500 text-sm">*</sup></p>
                                <input v-model="form.number" required
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                    type="text" />
                            </div>

                            <div class="flex max-lg:flex-col items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 w-full">
                                    <p>Марка <sup class="text-red-500 text-sm">*</sup></p>
                                    <input v-model="form.brand" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                        type="text" />
                                </div>
                                <div class="flex flex-col justify-end gap-2 max-lg:w-full">
                                    <p>Год выпуска <sup class="text-red-500 text-sm">*</sup></p>
                                    <input v-model.number="form.year" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                        type="number" />
                                </div>
                            </div>

                            <div class="flex items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 w-full">
                                    <p>Тип загрузки <sup class="text-red-500 text-sm">*</sup></p>
                                    <input v-model="form.loading_type" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                        type="text" />
                                </div>
                            </div>

                            <div class="flex items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 w-full">
                                    <p>Тип кузова <sup class="text-red-500 text-sm">*</sup></p>
                                    <input v-model="form.body_type" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                        type="text" />
                                </div>
                            </div>

                            <div class="flex justify-end w-full">
                                <div class="flex max-lg:flex-col max-lg:items-center pt-12 justify-end gap-4">
                                    <button type="button" @click="clearForm"
                                        class="w-auto text-xs text-accent transition-all duration-500 ease-in-out hover:border-accent border-b border-transparent text-center whitespace-nowrap cursor-pointer">Очистить
                                        форму</button>
                                    <button type="button" @click="saveFormToLocalStorage"
                                        class="px-4 py-2 text-accent border border-accent outline-none flex gap-2 rounded-full cursor-pointer whitespace-nowrap items-center">
                                        <img class="w-auto h-[1.5cap]" :src="editForm" alt="editForm" />
                                        <span class="text-xs">Сохранить как черновик</span>
                                    </button>
                                    <button type="submit"
                                        class="w-auto px-6 py-3 text-xs text-white bg-accent rounded-full text-center whitespace-nowrap cursor-pointer">Опубликовать</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>
        </div>
    </teleport>
</template>