<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

// IMAGES
import cancel from '@/assets/images/icons/cancel.svg'

const user = computed(() => usePage().props.auth.user)
const users = computed(() => usePage().props.users || [])

const filters = ref({
    id: '',
    name: '',
    surname: '',
    email: '',
    phone: '',
    company_name: ''
})

const filteredUsers = computed(() => {
    return users.value.filter(user => {
        let match = true;
        if (filters.value.id && user.id.toString() !== filters.value.id.toString()) {
            match = false;
        }
        if (filters.value.email && user.email.toLowerCase() !== filters.value.email.toLowerCase()) {
            match = false;
        }
        if (filters.value.phone && user.phone !== filters.value.phone) {
            match = false;
        }
        if (filters.value.company_name && user.company?.name.toLowerCase() !== filters.value.company_name.toLowerCase()) {
            match = false;
        }
        const nameSearch = (filters.value.name ?? '').trim().toLowerCase();
        if (nameSearch && !user.name.toLowerCase().includes(nameSearch)) {
            match = false;
        }

        return match;
    });
});

const resetFilters = () => {
    filters.value = {
        id: '',
        name: '',
        surname: '',
        email: '',
        phone: '',
        company_name: ''
    };
}

const blockUser = async (userId) => {
    if (!confirm('Вы уверены, что хотите заблокировать этого пользователя?')) return;
    try {
        const response = await axios.post(route('users.block', userId));
        if (response.data.success) {
            const index = users.value.findIndex(u => u.id === userId);
            if (index !== -1) {
                users.value[index].is_active = false;
            }
            alert('Пользователь успешно заблокирован');
        } else {
            alert('Не удалось заблокировать пользователя');
        }
    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <AppLayout
        class="flex flex-col items-start ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:max-xl:w-full max-lg:ml-0">
        <section class="w-full flex flex-col gap-8 p-10 pt-16 max-lg:p-6">
            <div class="flex justify-center w-full max-lg:gap-4 items-center font-bold">
                <h1 class="font-bold text-3xl text-light-gray text-center font-alumini">Пользователи</h1>
            </div>

            <div
                class="flex max-xl:flex-col max-xl:items-center items-end justify-between gap-6 border-b border-light-gray pb-12">
                <div class="flex max-xl:flex-col gap-4 max-xl:w-3/4 max-xl:gap-2">
                    <div class="flex flex-col justify-end gap-2 max-w-28 max-xl:max-w-full">
                        <p>ID</p>
                        <input name="id" v-model="filters.id"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-40 max-xl:max-w-full">
                        <p>Имя</p>
                        <input name="name" v-model="filters.name"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-32 max-xl:max-w-full">
                        <p>Email</p>
                        <input name="email" v-model="filters.email"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-32 max-xl:max-w-full">
                        <p>Телефон</p>
                        <input name="phone" v-model="filters.phone"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-0.5 outline-none"
                            type="text" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 max-w-32 max-xl:max-w-full">
                        <p>Компания</p>
                        <input name="company_name" v-model="filters.company_name"
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
                                Фамилия</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Имя</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Email</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Телефон</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Компания</th>
                            <th scope="col" v-if="user?.is_admin"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Управление</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#B2B2B2] overflow-y-auto text-[#424242]">
                        <tr v-for="userItem in filteredUsers" :key="userItem.id">
                            <td class="px-6 py-2 whitespace-nowrap text-sm">{{ userItem.id }}</td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p>{{ userItem.surname }}</p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p>{{ userItem.name }}</p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p>{{ userItem.email }}</p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p>{{ userItem.phone }}</p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p>{{ userItem.company.name }}</p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm text-light-gray">
                                <p v-if="!userItem.is_active" class="text-red-500">Заблокирован</p>
                                <button v-if="user?.is_admin && userItem.is_active" @click="blockUser(userItem.id)"
                                    class="px-4 py-1.5 text-dark-blue border border-dark-blue outline-none rounded-2xl cursor-pointer">Заблокировать</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="grid grid-cols-3 max-sm:grid-cols-1 gap-4 xl:hidden w-full">
                    <div class="flex flex-col items-start justify-center bg-light p-4 rounded-2xl">
                        <p class="font-semibold">ID</p>
                        <p>77605</p>
                        <p class="font-semibold">Место загрузки</p>
                        <p>RU. Москва</p>
                        <p>18.02.25</p>
                        <p class="font-semibold">Место рагрузки</p>
                        <p>BY. Минск</p>
                        <p>23.05.25</p>
                        <p class="font-semibold">Информация о грузе</p>
                        <p>22т. 92м, Отдельная машина</p>
                        <p class="font-semibold">Цена</p>
                        <p>400000 RUB</p>
                        <p>Без НДС</p>
                        <p>Без Предоплат</p>
                        <p class="font-semibold">Цена</p>
                        <p class="font-semibold">Заказчик</p>
                        <p>ООО Технопарк</p>
                        <p>+7(777)777 77-77</p>
                        <p class="font-semibold">Заявка</p>
                        <select class="border-2 border-light-gray rounded-lg px-3 py-1 cursor-pointer"
                            name="application" id="application">
                            <option value="Доставлено">Доставлено</option>
                            <option value="В пути">В пути</option>
                        </select>
                    </div>

                </div>
            </div>
        </section>
    </AppLayout>
</template>