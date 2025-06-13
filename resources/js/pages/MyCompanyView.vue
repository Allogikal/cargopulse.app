<script setup>
import AddEmployeeModal from '../components/modals/AddEmployeeModal.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { ref, computed } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

// IMAGES
import logout from '@/assets/images/icons/logout.svg'
import rate from '@/assets/images/icons/rate.svg'
import copy from '@/assets/images/icons/copy.svg'
import geo from '@/assets/images/icons/geo.svg'
import browse from '@/assets/images/icons/browse.svg'
import phone from '@/assets/images/icons/phone.svg'
import homeIcon from '@/assets/images/icons/home.svg'
import email from '@/assets/images/icons/email.svg'
import edit from '@/assets/images/icons/edit.svg'
import placeholder from '@/assets/images/placeholder.webp'
import checkmark from '@/assets/images/icons/checkmark.svg'

const isModalOpen = ref(false)
const openModal = () => {
    isModalOpen.value = true
}
const closeModal = () => {
    isModalOpen.value = false
}
const handleSubmit = (userId) => {
    const payload = {
        company_id: user.value.company.id,
        user_id: userId
    }
    axios.post(route('add.employee'), payload)
        .then(() => {
            closeModal()
            fetchEmployees()
        })
        .catch((error) => {
            console.error(error)
        })
}

const form = useForm()
const user = computed(() => usePage().props.auth.user)
const companyUsers = computed(() => usePage().props.users)
const unassignedUsers = computed(() => usePage().props.unassignedUsers || [])
const fetchEmployees = () => {
    window.location.reload()
}

const handleLogout = () => {
    form.post(route('logout'))
}

const copiedText = ref(null)
const copyToClipboard = (text) => {
    navigator.clipboard.writeText(text).then(() => {
        copiedText.value = text
        setTimeout(() => {
            copiedText.value = null
        }, 1500)
    }).catch(err => {
        return
    })
}
</script>

<template>
    <AppLayout class="justify-end flex">
        <main
            class="flex flex-col items-start ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:max-xl:w-full max-lg:ml-0 overflow-y-auto">
            <section class="w-full flex flex-col gap-4 px-12 max-lg:px-6 pb-12">
                <div class="flex justify-end w-full border-b border-light-gray">
                    <div class="flex items-center text-accent py-6 gap-3 pr-8">
                        <button @click.prevent="handleLogout" class="flex items-center gap-2 cursor-pointer">
                            <p>Выйти</p>
                            <img :src="logout" alt="logout" />
                        </button>
                    </div>
                </div>

                <div class="flex max-sm:flex-col w-full items-start justify-start gap-8 max-w-1/2 max-sm:max-w-full">
                    <img class="object-center object-cover max-w-32 max-lg:max-w-64 rounded-2xl"
                        :src="user.avatar ? '/storage/' + user.avatar : placeholder" alt="placeholder" />
                    <div class="flex flex-col gap-8">
                        <div class="flex max-sm:flex-wrap max-sm:items-start gap-4 items-center max-sm:justify-center">
                            <h2 class="text-2xl font-bold text-dark-blue">{{ user?.company.name }}</h2>
                            <div
                                class="text-center text-sm shadow-xl shadow-black/25 py-2 px-6 rounded-xl bg-[#EEF0FF] text-light-gray">
                                ID 023{{ user?.company.id }}</div>
                        </div>
                        <div class="flex max-sm:flex-wrap items-center max-sm:justify-center gap-12 max-sm:gap-6">
                            <div class="flex flex-col gap-px whitespace-nowrap max-sm:items-center">
                                <p class="text-[#8287AB] text-sm">ИНН</p>
                                <p class="text-dark-blue text-sm">{{ user?.company.inn }}</p>
                            </div>
                            <div class="flex flex-col gap-px whitespace-nowrap max-sm:items-center">
                                <p class="text-[#8287AB] text-sm">Деятельность</p>
                                <p class="text-dark-blue text-sm">{{ user?.company.activity }}</p>
                            </div>
                            <div class="flex flex-col gap-px whitespace-nowrap max-sm:items-center">
                                <p class="text-[#BEC2DA] text-sm">Рейтинг</p>
                                <div class="text-[#BEC2DA] text-xl font-bold flex gap-2 items-center">
                                    <img class="size-6" :src="rate" alt="rate" />
                                    <p>{{ user?.company.rate }}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 max-lg:grid-cols-2 max-sm:grid-cols-1 max-sm:gap-12 w-full gap-18">
                    <div class="flex flex-col gap-3">
                        <div class="flex justify-between max-lg:flex-col max-lg:items-start items-center">
                            <h2 class="font-semibold text-dark-blue text-base">Контакты компании</h2>
                        </div>
                        <div class="flex flex-col gap-3">
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-3 flex justify-center items-center size-12 h-auto rounded-xl"
                                    :src="email" alt="email" />
                                <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                    <p class="text-[#8287AB] text-sm">Email</p>
                                    <a :href="`mailto:${user?.company.email}`" class="text-dark-blue text-sm">{{
                                        user?.company.email }}</a>
                                </div>
                                <img @click.prevent="copyToClipboard(user?.company.email)" class="size-5 cursor-pointer"
                                    :src="copiedText === user?.company.email ? checkmark : copy" alt="copy" />
                            </div>
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-3 flex justify-center items-center size-12 h-auto rounded-xl"
                                    :src="browse" alt="browse" />
                                <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                    <p class="text-[#8287AB] text-sm">Веб-сайт</p>
                                    <p class="text-dark-blue text-sm">--</p>
                                </div>
                            </div>
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-3 flex justify-center items-center size-12 h-auto rounded-xl"
                                    :src="phone" alt="phone" />
                                <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                    <p class="text-[#8287AB] text-sm">Телефон</p>
                                    <a :href="`tel:${user?.company.phone}`" class="text-dark-blue text-sm">{{
                                        user?.company.phone }}</a>
                                </div>
                                <img @click.prevent="copyToClipboard(user?.company.phone)" class="size-5 cursor-pointer"
                                    :src="copiedText === user?.company.phone ? checkmark : copy" alt="copy" />
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <h2 class="font-semibold text-dark-blue text-base">Адрес компании</h2>
                        </div>
                        <div class="flex flex-col gap-3">
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-3 flex justify-center items-center size-12 h-auto rounded-xl"
                                    :src="geo" alt="geo" />
                                <div class="flex flex-col gap-px justify-end">
                                    <p class="text-[#8287AB] text-sm">Страна, город</p>
                                    <p class="text-dark-blue text-sm">{{
                                        user?.company.country }}, {{
                                        user?.company.city }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-3 flex justify-center items-center size-12 h-auto rounded-xl"
                                    :src="homeIcon" alt="homeIcon" />
                                <div class="flex flex-col gap-px justify-end">
                                    <p class="text-[#8287AB] text-sm">Адрес регистрации</p>
                                    <p class="text-dark-blue text-sm">{{
                                        user?.company.registration_address }}</p>
                                </div>
                            </div>
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-3 flex justify-center items-center size-12 h-auto rounded-xl"
                                    :src="homeIcon" alt="homeIcon" />
                                <div class="flex flex-col gap-px justify-end">
                                    <p class="text-[#8287AB] text-sm">Почтовый адрес</p>
                                    <p class="text-dark-blue text-sm">{{
                                        user?.company.postal_address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between">
                            <h2 class="font-semibold text-dark-blue text-base">Актуальные грузы</h2>
                        </div>
                        <a :href="route('cargos')"
                            class="rounded-2xl border-l-2 border-accent text-accent bg-[#EEF0FF] flex flex-col items-start justify-end p-6 max-w-2/3 min-h-[140px] hover:scale-105 transition-all duration-500 ease-in-out">
                            <p class="font-bold text-2xl">{{
                                user?.company.cargos.length }}</p>
                            <p class="font-normal text-sm">грузов</p>
                        </a>
                        <div class="flex justify-between">
                            <h2 class="font-semibold text-dark-blue text-base">Статистика по грузам, транспорту</h2>
                        </div>
                        <div class="flex flex-wrap max-lg:gap-6 justify-between">
                            <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                <p class="text-[#8287AB] text-sm">Месяц</p>
                                <p class="text-dark-blue text-sm">{{
                                    user?.company.cargos_statistics_month }}</p>
                            </div>
                            <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                <p class="text-[#8287AB] text-sm">Год</p>
                                <p class="text-dark-blue text-sm">{{
                                    user?.company.cargos_statistics_year }}</p>
                            </div>
                            <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                <p class="text-[#8287AB] text-sm">Весь период</p>
                                <p class="text-dark-blue text-sm">{{
                                    user?.company.cargos_statistics_all_time }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between">
                            <h2 class="font-semibold text-dark-blue text-base">Дополнительная информация</h2>
                        </div>
                        <div class="grid grid-cols-2 justify-center items-center gap-18">
                            <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                <p class="text-[#8287AB] text-sm">Дата регистрации</p>
                                <p class="text-dark-blue text-sm">{{
                                    user?.company.registered_at }}</p>
                            </div>
                            <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                <p class="text-[#8287AB] text-sm">Последний вход</p>
                                <p class="text-dark-blue text-sm">{{
                                    user?.company.last_login }}</p>
                            </div>
                        </div>
                        <div class="flex justify-start gap-1">
                            <h2 class="font-semibold text-dark-blue text-base">Сотрудники</h2>
                            <p class="text-base text-accent">{{ companyUsers.length }}</p>
                        </div>
                        <div v-if="companyUsers.length === 0" class="text-accent font-semibold">
                            Сотрудники не найдены!
                        </div>
                        <div class="flex max-lg:flex-col justify-start gap-4 items-start">
                            <div class="flex gap-4 flex-wrap">
                                <div v-for="user in companyUsers" :key="user.id"
                                    class="group flex justify-center size-12 items-center">
                                    <img class="rounded-full object-center object-cover group-hover:brightness-100 brightness-25 transition-all ease-in-out duration-500"
                                        :src="user.avatar ? '/storage/' + user.avatar : placeholder" alt="Аватар" />
                                    <p
                                        class="absolute text-lg group-hover:opacity-0 transition-all duration-500 ease-in-out text-white">
                                        {{ user.name.charAt(0).toUpperCase() }}{{ user.surname.charAt(0).toUpperCase()
                                        }}</p>
                                </div>
                            </div>
                            <button @click="openModal" v-if="user?.is_admin"
                                class="w-auto px-6 py-3 text-xs text-white bg-accent rounded-full text-center whitespace-nowrap cursor-pointer">Добавить
                                сотрудника</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <AddEmployeeModal v-if="isModalOpen" @close="closeModal" @submit="handleSubmit"
            :unassignedUsers="unassignedUsers" />
    </AppLayout>
</template>