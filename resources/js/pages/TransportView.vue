<script setup>
import { ref, computed } from 'vue'
import AddTransportModal from '@/components/modals/AddTransportModal.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { usePage, router } from '@inertiajs/vue3'

// IMAGES
import cancel from '@/assets/images/icons/cancel.svg'

const isTransportModalOpen = ref(false)
const openTransportModal = () => {
    isTransportModalOpen.value = true
}
const closeTransportModal = () => {
    isTransportModalOpen.value = false
}

const user = computed(() => usePage().props.auth.user)
const transports = computed(() => usePage().props.transports || [])

const filters = ref({
    id: '',
    number: '',
    brand: '',
    year: '',
    loading_type: '',
    body_type: ''
})

const filteredTransports = computed(() => {
    return transports.value.filter(transport => {
        let match = true;
        if (filters.value.id && transport.id.toString() !== filters.value.id.toString()) {
            match = false;
        }
        if (filters.value.number && transport.number !== filters.value.number) {
            match = false;
        }
        if (filters.value.brand && transport.brand.toLowerCase() !== filters.value.brand.toLowerCase()) {
            match = false;
        }
        if (filters.value.year && transport.year !== parseInt(filters.value.year)) {
            match = false;
        }
        if (filters.value.loading_type && transport.loading_type !== filters.value.loading_type) {
            match = false;
        }
        if (filters.value.body_type && transport.body_type !== filters.value.body_type) {
            match = false;
        }

        return match;
    });
});

const resetFilters = () => {
    filters.value = {
        id: '',
        number: '',
        brand: '',
        year: '',
        loading_type: '',
        body_type: ''
    };
}

const deleteTransport = (transportId) => {
    if (confirm('Вы уверены, что хотите удалить этот вид транспорта?')) {
        router.delete(route('transport.destroy', transportId), {
            onSuccess: () => { console.log('success') },
            onError: (errors) => {
                console.error(errors)
            }
        })
    }
}
</script>

<template>
    <AppLayout
        class="flex flex-col items-start ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:max-xl:w-full max-lg:ml-0">
        <AddTransportModal :is-transport-modal-open="isTransportModalOpen" v-if="isTransportModalOpen"
            @close="closeTransportModal" />

        <section class="w-full flex flex-col gap-8 p-10 pt-12 max-lg:p-6">
            <div :class="{
                'justify-between w-full max-w-1/2': user?.is_admin,
                'justify-center w-full max-w-full': !user?.is_admin
            }"
                class="flex max-md:flex-col-reverse justify-between w-full max-w-1/2 max-lg:justify-center max-lg:gap-4 max-lg:max-w-full items-center font-bold">
                <button @click="openTransportModal" v-if="user?.is_admin"
                    class="bg-dark-blue hover:border-dark-blue hover:bg-transparent border-transparent border-2 hover:text-dark-border transition-all duration-300 ease-in-out cursor-pointer text-white w-auto px-4 py-2 rounded-xl shadow-xl shadow-black/25 text-base flex items-center justify-between gap-4">
                    Добавить Транспорт
                    <span class="text-2xl">+</span>
                </button>
                <h1 class="font-bold text-3xl text-light-gray text-center font-alumini">Поиск Транспорта</h1>
            </div>

            <div class="flex max-xl:flex-col max-xl:items-center items-end justify-between gap-6">
                <div class="flex max-xl:flex-col gap-4 max-xl:w-3/4 max-xl:gap-2">
                    <div class="flex flex-col justify-end gap-2 max-w-28 max-xl:max-w-full">
                        <p>ID</p>
                        <input name="id" v-model="filters.id"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-40 max-xl:max-w-full">
                        <p>Номер транспорта</p>
                        <input name="number" v-model="filters.number"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-32 max-xl:max-w-full">
                        <p>Марка</p>
                        <input name="brand" v-model="filters.brand"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-32 max-xl:max-w-full">
                        <p>Год выпуска</p>
                        <input name="year" v-model="filters.year"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="number" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-32 max-xl:max-w-full">
                        <p>Тип загрузки</p>
                        <input name="loading_type" v-model="filters.loading_type"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-32 max-xl:max-w-full">
                        <p>Тип кузова</p>
                        <input name="body_type" v-model="filters.body_type"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                </div>

                <div class="flex gap-8 items-end justify-center">
                    <div @click="resetFilters" class="flex items-end gap-2 cursor-pointer">
                        <img class="pb-2" :src="cancel" alt="cancel" />
                        <p class="pb-1">Сбросить</p>
                    </div>
                    <button
                        class="px-8 py-1 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Поиск</button>
                </div>
            </div>

            <div>
                <table class="w-full max-xl:w-3/4 divide-y-2 divide-black/25 max-xl:hidden">
                    <thead class="text-dark-blue">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Номер транспорта</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Марка</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Год выпуска</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Тип загрузки</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Тип кузова</th>
                            <th scope="col" v-if="user?.is_admin"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Управление</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#B2B2B2] overflow-y-auto text-[#424242]">
                        <tr v-for="transport in filteredTransports" :key="transport.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">010{{ transport.id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <p>{{ transport.number }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <p>{{ transport.brand }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <p class="font-semibold">{{ transport.year }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <p class="font-semibold">{{ transport.loading_type }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <p class="font-semibold">{{ transport.body_type }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-light-gray">
                                <button v-if="user?.is_admin" @click="deleteTransport(transport.id)"
                                    class="px-4 py-1 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Удалить
                                    транспорт</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="grid grid-cols-3 max-sm:grid-cols-1 gap-4 xl:hidden w-full">
                    <div v-for="transport in filteredTransports" :key="transport.id"
                        class="flex flex-col items-start justify-center bg-light p-4 rounded-2xl">
                        <p class="font-semibold">ID</p>
                        <p>010{{ transport.id }}</p>
                        <p class="font-semibold">Номер транспорта</p>
                        <p>{{ transport.number }}</p>
                        <p class="font-semibold">Марка</p>
                        <p>{{ transport.brand }}</p>
                        <p class="font-semibold">Год выпуска</p>
                        <p>{{ transport.year }}</p>
                        <p class="font-semibold">Тип загрузки</p>
                        <p>{{ transport.loading_type }}</p>
                        <p class="font-semibold">Тип кузова</p>
                        <p>{{ transport.body_type }}</p>
                        <button v-if="user?.is_admin" @click="deleteTransport(transport.id)"
                            class="px-4 py-1 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Удалить
                            транспорт</button>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>