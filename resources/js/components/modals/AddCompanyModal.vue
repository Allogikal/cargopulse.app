<script setup>
import { onMounted, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

// IMAGES
import closeWhite from '@/assets/images/icons/close_white.svg'
import editForm from '@/assets/images/icons/edit_form.svg'

const emit = defineEmits(['close', 'submit'])
const user = computed(() => usePage().props.auth.user)
defineProps(['isCompanyModalOpen'])

const form = useForm({
    user_id: user.value.id,
    name: '',
    inn: '',
    country: '',
    city: '',
    phone: '',
    registration_address: 'г. Москва, ул. Ленина, д. 1',
    postal_address: '101000, г. Москва, ул. Ленина, д. 1',
    rate: 0,
    email: 'company1@example.com',
    activity: 'Организация перевозок, доставка грузов',
    cargos_statistics_month: 0,
    cargos_statistics_year: 0,
    cargos_statistics_all_time: 0,
    registered_at: '2025-06-13 06:06:20',
    last_login: '2025-06-13 06:06:20'
})

const submitForm = () => {
    const componentEmit = emit;

    form.post(route('companies.store'), {
        preserveScroll: true,
        onSuccess: () => {
            clearForm();
            componentEmit('close');
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Добавлена новая компания!",
                showConfirmButton: false,
                timer: 2000
            });
        },
        onError: (e) => {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Ошибка создания новой компании!",
                showConfirmButton: false,
                timer: 2000
            });
            console.log(e);
        }
    });
}

const clearForm = () => {
    form.reset();
}

const saveFormToLocalStorage = () => {
    localStorage.setItem('companyFormData', JSON.stringify(form.data()));
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Форма сохранена как черновик",
        showConfirmButton: false,
        timer: 2000
    });
}

onMounted(() => {
    const savedData = localStorage.getItem('companyFormData');
    if (savedData) {
        const parsedData = JSON.parse(savedData);
        for (const key in parsedData) {
            if (form.hasOwnProperty(key)) {
                form[key] = parsedData[key];
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
                <div v-show="isCompanyModalOpen"
                    class="bg-white z-[10000] rounded-2xl shadow-2xl shadow-black/50 max-w-1/3 max-lg:max-w-[90%] min-h-[90dvh] max-lg:min-h-auto w-full transform scale-95 opacity-0 transition-all duration-500 relative flex flex-col"
                    :class="{ 'scale-100 opacity-100': true }">
                    <div class="flex w-full justify-between items-center p-4 bg-dark-blue rounded-t-2xl">
                        <p class="text-[#EAEAEA] text-xs uppercase font-semibold tracking-wider">Добавить Компанию</p>
                        <button @click="$emit('close')"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer">
                            <img :src="closeWhite" alt="closeWhite" />
                        </button>
                    </div>

                    <div class="flex gap-4 justify-center items-center p-6 max-lg:overflow-scroll">
                        <form @submit.prevent="submitForm"
                            class="flex flex-col gap-3 h-auto items-start justify-start w-full">
                            <p class="text-xs uppercase font-normal tracking-wider">Новая компания</p>

                            <div class="flex flex-col justify-end gap-2 w-full">
                                <p>
                                    Название компании
                                    <sup class="text-red-500 text-sm">*</sup>
                                </p>
                                <input v-model="form.name"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                    type="text" />
                            </div>

                            <div class="flex flex-col justify-end gap-2 w-full">
                                <p>
                                    ИНН
                                    <sup class="text-red-500 text-sm">*</sup>
                                </p>
                                <input v-model.number="form.inn"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                    type="number" />
                            </div>

                            <div class="flex max-lg:flex-col items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 w-full">
                                    <p>
                                        Страна
                                        <sup class="text-red-500 text-sm">*</sup>
                                    </p>
                                    <select v-model="form.country"
                                        class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer"
                                        name="#">
                                        <option value="">Выберите страну</option>
                                        <option value="Россия">Россия</option>
                                        <option value="Беларусь">Беларусь</option>
                                        <option value="Казахстан">Казахстан</option>
                                        <option value="Украина">Украина</option>
                                    </select>
                                </div>
                                <div class="flex flex-col justify-end gap-2 max-lg:w-full">
                                    <p>
                                        Город / регион
                                        <sup class="text-red-500 text-sm">*</sup>
                                    </p>
                                    <select v-model="form.city"
                                        class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer"
                                        name="#">
                                        <option value="">Выберите город/регион</option>
                                        <option value="Москва">Москва</option>
                                        <option value="Минск">Минск</option>
                                        <option value="Алматы">Алматы</option>
                                        <option value="Киев">Киев</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 w-full">
                                    <p>
                                        Номер телефона компании
                                        <sup class="text-red-500 text-sm">*</sup>
                                    </p>
                                    <input v-model="form.phone"
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase px-1"
                                        type="tel" />
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