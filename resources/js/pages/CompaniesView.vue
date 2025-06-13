<script setup>
import { ref, computed } from 'vue'
import AddCompanyModal from '@/components/modals/AddCompanyModal.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { usePage, router } from '@inertiajs/vue3'

// IMAGES
import cancel from '@/assets/images/icons/cancel.svg'

const isCompanyModalOpen = ref(false)
const openCompanyModal = () => {
    isCompanyModalOpen.value = true
}
const closeCompanyModal = () => {
    isCompanyModalOpen.value = false
}
const handleCompanySubmit = (data) => {
    console.log('Компания:', data)
    closeCompanyModal()
}

const user = computed(() => usePage().props.auth.user)
const companies = computed(() => usePage().props.companies || [])

const filters = ref({
    search: '',
    country: '',
    city: ''
})

const filteredCompanies = computed(() => {
    return companies.value.filter(company => {
        let match = true;
        const searchValue = filters.value.search.toLowerCase();
        if (searchValue && ![
            company.id.toString().includes(searchValue),
            company.inn?.toString().includes(searchValue),
            company.name.toLowerCase().includes(searchValue)
        ].some(Boolean)) {
            match = false;
        }
        if (filters.value.country && company.country !== filters.value.country) {
            match = false;
        }
        if (filters.value.city && company.city !== filters.value.city) {
            match = false;
        }

        return match;
    });
});

const resetFilters = () => {
    filters.value = {
        search: '',
        country: '',
        city: ''
    };
}

const deleteCompany = (companyId) => {
    if (confirm('Вы уверены, что хотите удалить эту компанию?')) {
        router.delete(route('companies.destroy', companyId), {
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
        <AddCompanyModal :is-company-modal-open="isCompanyModalOpen" v-if="isCompanyModalOpen"
            @close="closeCompanyModal" @submit="handleCompanySubmit" />

        <section class="w-full flex flex-col gap-8 p-10 pt-16 max-lg:p-6">
            <div :class="{
                'justify-between w-full max-w-1/2': user?.is_admin,
                'justify-center w-full max-w-full': !user?.is_admin
            }"
                class="flex max-md:flex-col-reverse justify-between w-full max-w-1/2 max-lg:justify-center max-lg:gap-4 max-lg:max-w-full items-center font-bold">
                <button @click="openCompanyModal" v-if="user?.is_admin"
                    class="bg-dark-blue hover:border-dark-blue hover:bg-transparent border-transparent border-2 hover:text-dark-border transition-all duration-300 ease-in-out cursor-pointer text-white w-auto px-4 py-2 rounded-xl shadow-xl shadow-black/25 text-base flex items-center justify-between gap-4">
                    Добавить Компанию
                    <span class="text-2xl">+</span>
                </button>
                <h1 class="font-bold text-3xl text-light-gray text-center font-alumini">Поиск Компании</h1>
            </div>

            <div
                class="flex max-2xl:flex-wrap items-end justify-between gap-2 max-sm:w-full border-b border-light-gray pb-12">
                <div class="flex flex-wrap gap-4">
                    <div class="flex flex-col justify-end gap-2 min-w-1/4">
                        <p>Название компании / ИНН / ID</p>
                        <input name="search" v-model="filters.search"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2">
                        <p>Страна</p>
                        <select v-model="filters.country"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer"
                            name="country">
                            <option value="">Выберите страну</option>
                            <option value="Россия">Россия</option>
                            <option value="Беларусь">Беларусь</option>
                            <option value="Казахстан">Казахстан</option>
                            <option value="Украина">Украина</option>
                        </select>
                    </div>
                    <div class="flex flex-col justify-end gap-2">
                        <p>Город / регион</p>
                        <select v-model="filters.city"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer"
                            name="city">
                            <option value="">Выберите город / регион</option>
                            <option value="Москва">Москва</option>
                            <option value="Минск">Минск</option>
                            <option value="Алматы">Алматы</option>
                            <option value="Киев">Киев</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 items-end justify-center">
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
                                ИНН</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Cтрана</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Город</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Компания</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Номер</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#B2B2B2] overflow-y-auto text-[#424242]">
                        <tr v-for="company in filteredCompanies" :key="company.id">
                            <td class="px-6 py-3 whitespace-nowrap text-sm">0220{{ company.id }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm">
                                <p>{{ company.inn }}</p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm">
                                <p>{{ company.country }}</p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm">
                                <p>{{ company.city }}</p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm">
                                <p>{{ company.name }}</p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm">
                                <p>{{ company.phone }}</p>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-light-gray">
                                <button v-if="user?.is_admin" @click="deleteCompany(company.id)"
                                    class="px-4 py-1.5 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Удалить
                                    компанию</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="grid grid-cols-3 max-sm:grid-cols-1 gap-4 xl:hidden w-full">
                    <div v-for="company in filteredCompanies" :key="company.id"
                        class="flex flex-col items-start justify-center bg-light p-4 gap-1 rounded-2xl">
                        <p class="font-semibold">ID</p>
                        <p>0220{{ company.id }}</p>
                        <p class="font-semibold">ИНН</p>
                        <p>{{ company.inn }}</p>
                        <p class="font-semibold">Страна</p>
                        <p>{{ company.country }}</p>
                        <p class="font-semibold">Город</p>
                        <p>{{ company.city }}</p>
                        <p class="font-semibold">Компания</p>
                        <p>{{ company.name }}</p>
                        <p class="font-semibold">Номер</p>
                        <p>{{ company.phone }}</p>
                        <button v-if="user?.is_admin" @click="deleteCompany(company.id)" class=" px-4 py-1.5 text-accent border border-accent outline-none rounded-2xl
                            cursor-pointer">Удалить
                            компанию</button>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>