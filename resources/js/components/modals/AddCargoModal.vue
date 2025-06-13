<script setup>
import { ref, onMounted, watch, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

// IMAGES
import closeWhite from '@/assets/images/icons/close_white.svg'
import arrow from '@/assets/images/icons/arrow.svg'
import editForm from '@/assets/images/icons/edit_form.svg'

const user = computed(() => usePage().props.auth.user);
const companyId = computed(() => user.value?.company?.id);

const emit = defineEmits(['close', 'submit'])
defineProps(['isModalOpen'])

const form = useForm({
    company_id: companyId.value || null,
    loading_date: '',
    loading_country: '',
    loading_city: '',
    loading_index: '',
    weight_tons: null,
    volume_m3: null,
    additional_weight: null,
    additional_info: '',
    unloading_country: '',
    unloading_index: '',
    unloading_city: '',
    unloading_date: '',
    price: null,
    currency: 'Rub',
    vat_included: false,
    prepayment_required: false
})

const errors = ref({});

const countries = [
    { name: 'Россия', index: '105005', city: 'Москва' },
    { name: 'Беларусь', index: '220004', city: 'Минск' },
    { name: 'Казахстан', index: '050000', city: 'Алматы' },
    { name: 'Украина', index: '01008', city: 'Киев' }
];

const selectedLocation = ref(null);
const selectedUnloadingLocation = ref(null);

watch(selectedLocation, (newVal) => {
    if (newVal) {
        form.loading_country = newVal.name;
        form.loading_index = newVal.index;
        form.loading_city = newVal.city;
    } else {
        form.loading_country = '';
        form.loading_index = '';
        form.loading_city = '';
    }
});

watch(selectedUnloadingLocation, (newVal) => {
    if (newVal) {
        form.unloading_country = newVal.name;
        form.unloading_index = newVal.index;
        form.unloading_city = newVal.city;
    } else {
        form.unloading_country = '';
        form.unloading_index = '';
        form.unloading_city = '';
    }
});

const submitForm = () => {
    if (form.loading_date && form.unloading_date && new Date(form.loading_date) > new Date(form.unloading_date)) {
        errors.value.date_error = 'Дата загрузки не может быть позже даты разгрузки';
        return;
    }
    delete errors.value.date_error;
    const componentEmit = emit;

    form.post(route('cargos.store'), {
        preserveScroll: true,
        onSuccess: () => {
            clearForm();
            componentEmit('close');
        },
        onError: (e) => {
            errors.value = e;
        }
    });
}

const clearForm = () => {
    form.reset();
    errors.value = {};
}

const saveFormToLocalStorage = () => {
    localStorage.setItem('cargoFormData', JSON.stringify(form.data()));
    alert('Форма сохранена как черновик');
}

onMounted(() => {
    const savedData = localStorage.getItem('cargoFormData');
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
                <div v-show="isModalOpen"
                    class="bg-white z-[10000] rounded-2xl shadow-2xl shadow-black/50 max-w-3/4 max-lg:max-w-[90%] min-h-[90dvh] max-lg:max-h-[50dvh] w-full transform scale-95 opacity-0 transition-all duration-500 relative flex flex-col"
                    :class="{ 'scale-100 opacity-100': true }">
                    <div class="flex w-full justify-between items-center p-4 bg-dark-blue rounded-t-2xl">
                        <p class="text-[#EAEAEA] text-xs uppercase font-semibold tracking-wider">Добавить груз</p>
                        <button @click="$emit('close')"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer">
                            <img :src="closeWhite" alt="closeWhite" />
                        </button>
                    </div>
                    <form @submit.prevent="submitForm"
                        class="grid grid-cols-[1fr_0.1fr_1fr] max-sm:grid-cols-1 max-xl:grid-cols-2 gap-4 justify-center justify-items-center max-lg:overflow-auto items-start p-6">
                        <div class="flex flex-col gap-3 h-auto items-start justify-start w-full">
                            <p class="text-xs uppercase font-normal tracking-wider">Загрузка</p>
                            <div class="flex flex-col justify-end gap-2 w-full">
                                <p>
                                    Страна, индекс, город
                                    <sup class="text-red-500 text-sm">*</sup>
                                </p>
                                <select v-model="selectedLocation"
                                    class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer w-full"
                                    name="location" required>
                                    <option value="">Выберите страну</option>
                                    <option v-for="(country, index) in countries" :key="index" :value="country">
                                        {{ country.name }}, {{ country.index }}, {{ country.city }}
                                    </option>
                                </select>
                            </div>
                            <div class="flex max-lg:flex-wrap items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 max-sm:w-full">
                                    <p class="text-light-gray">
                                        Дата загрузки
                                        <sup class="text-red-500 text-sm">*</sup>
                                    </p>
                                    <input v-model="form.loading_date" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                                        type="date" />
                                </div>
                            </div>
                            <div class="flex max-lg:flex-wrap items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 max-sm:w-full">
                                    <p>
                                        Вес, т
                                        <sup class="text-red-500 text-sm">*</sup>
                                    </p>
                                    <input v-model.number="form.weight_tons" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                                        type="number" />
                                </div>
                                <div class="flex flex-col justify-end gap-1 max-sm:w-full">
                                    <p>
                                        Объем, m<sup>3</sup>
                                    </p>
                                    <input v-model.number="form.volume_m3" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                                        type="number" />
                                </div>
                                <div class="flex flex-col justify-end gap-1 max-sm:w-full">
                                    <p>Дополнительный вес</p>
                                    <input v-model.number="form.additional_weight" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                                        type="number" />
                                </div>
                            </div>
                            <div class="flex w-full">
                                <div class="flex flex-col items-start justify-center gap-2 w-full">
                                    <p>Дополнительная информация</p>
                                    <textarea placeholder="Введите дополнительную информацию" required
                                        v-model="form.additional_info" rows="4"
                                        class="text-light-gray border border-light-gray rounded-lg p-3 outline-none w-full resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col justify-start mt-14 max-lg:hidden">
                            <div
                                class="bg-[#EEF0FF] rounded-full w-auto flex flex-col justify-center items-center h-auto px-2 py-3 -z-10">
                                <img class="w-5 h-auto" :src="arrow" alt="arrow" />
                                <img class="rotate-180 w-5 h-auto" :src="arrow" alt="arrow" />
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 h-auto items-start justify-start w-full">
                            <p class="text-xs uppercase font-normal tracking-wider">Разгрузка</p>
                            <div class="flex flex-col justify-end gap-2 w-full">
                                <p>
                                    Страна, индекс, город
                                    <sup class="text-red-500 text-sm">*</sup>
                                </p>
                                <select v-model="selectedUnloadingLocation"
                                    class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer w-full"
                                    name="unloading_location" required>
                                    <option value="">Выберите страну</option>
                                    <option v-for="(country, index) in countries" :key="index" :value="country">
                                        {{ country.name }}, {{ country.index }}, {{ country.city }}
                                    </option>
                                </select>
                            </div>
                            <div class="flex items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 max-sm:w-full">
                                    <p class="text-light-gray">
                                        Дата разгрузки
                                        <sup class="text-red-500 text-sm">*</sup>
                                    </p>
                                    <input v-model="form.unloading_date" required
                                        class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                                        type="date" />
                                </div>
                            </div>
                            <div class="flex flex-col justify-end gap-2 w-full">
                                <p>Ставка</p>
                                <div class="p-2 flex flex-col justify-end gap-2 w-full">
                                    <p>Цена</p>
                                    <div class="flex gap-2">
                                        <input placeholder="Цена" v-model.number="form.price" required
                                            class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none capitalize w-full max-w-1/2 px-1"
                                            type="number" />
                                        <select v-model="form.currency" required
                                            class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer uppercase"
                                            name="currency">
                                            <option value="Rub">RUB</option>
                                            <option value="USD">USD</option>
                                            <option value="EUR">EUR</option>
                                        </select>
                                    </div>
                                    <div class="flex items-start gap-4">
                                        <div class="flex flex-col justify-end gap-1 w-full">
                                            <p>НДС</p>
                                            <label class="flex items-center gap-2" for="attribute5">
                                                <input id="attribute5" v-model="form.vat_included" type="radio" required
                                                    :value="true" name="vat" />
                                                С НДС
                                            </label>
                                            <label class="flex items-center gap-2" for="attribute6">
                                                <input id="attribute6" v-model="form.vat_included" type="radio" required
                                                    :value="false" name="vat" />
                                                Без НДС
                                            </label>
                                        </div>
                                        <div class="flex flex-col justify-end gap-1 w-full">
                                            <p>Предоплата</p>
                                            <label class="flex items-center gap-2" for="attribute8">
                                                <input id="attribute8" v-model="form.prepayment_required" type="radio"
                                                    :value="true" required name="prepayment" />
                                                Да
                                            </label>
                                            <label class="flex items-center gap-2" for="attribute9">
                                                <input id="attribute9" v-model="form.prepayment_required" type="radio"
                                                    :value="false" required name="prepayment" />
                                                Нет
                                            </label>
                                        </div>
                                    </div>
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
                            <small v-if="errors.date_error" class="text-accent p-2 border border-text-accent">{{
                                errors.date_error }}</small>
                        </div>
                    </form>
                </div>
            </transition>
        </div>
    </teleport>
</template>