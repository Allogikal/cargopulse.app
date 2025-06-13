<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, usePage } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

// IMAGES
import placeholder from '@/assets/images/placeholder.webp'
import external from '@/assets/images/icons/external.svg'
import email from '@/assets/images/icons/email.svg'
import phone from '@/assets/images/icons/phone.svg'
import edit from '@/assets/images/icons/edit.svg'
import logout from '@/assets/images/icons/logout.svg'

const form = useForm({
    name: '',
    surname: '',
    email: '',
    phone: '',
    info: ''
})

const user = computed(() => usePage().props.auth.user)

const handleLogout = () => {
    form.post(route('logout'))
}

const isEditing = ref(false)

const startEditing = () => {
    isEditing.value = true
    form.name = user.value.name
    form.surname = user.value.surname
    form.email = user.value.email
    form.phone = user.value.phone
    form.info = user.value.info
}

const saveChanges = () => {
    if (!form.name || !form.surname || !form.email || !form.phone) {
        alert('Заполните все обязательные поля')
        return
    }

    form.put(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            window.location.reload();
        },
    })
}
</script>

<template>
    <AppLayout
        class="flex flex-col items-start ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:w-full max-lg:ml-0 overflow-y-auto">
        <section class="w-full flex flex-col gap-4 px-12 max-lg:px-6 pb-12">
            <div class="flex justify-end w-full border-b border-light-gray">
                <div class="flex items-center text-accent py-6 gap-3 pr-8">
                    <button @click.prevent="handleLogout" class="flex items-center gap-2 cursor-pointer">
                        <p>Выйти</p>
                        <img :src="logout" alt="logout" />
                    </button>
                </div>
            </div>

            <div
                class="flex max-sm:flex-col w-full items-start max-sm:items-center justify-start gap-8 max-w-1/2 max-lg:max-w-full pb-6">
                <img class="object-center object-cover max-w-32 max-lg:max-w-64 rounded-2xl"
                    :src="user.avatar ? '/storage/' + user.avatar : placeholder" alt="Аватар" />
                <div class="flex flex-col max-sm:items-center gap-8">
                    <div class="flex max-sm:flex-wrap max-sm:items-start gap-4 items-center max-sm:justify-center">
                        <h2 class="text-2xl font-bold text-dark-blue">{{ user?.name }} {{ user?.surname }}</h2>
                        <div
                            class="text-center text-sm shadow-xl shadow-black/25 py-2 whitespace-nowrap px-6 rounded-xl bg-[#EEF0FF] text-light-gray">
                            ID 000{{ user?.id }}</div>
                    </div>
                    <div class="flex max-sm:flex-col items-center max-sm:justify-center gap-8 max-sm:gap-4">
                        <div class="flex flex-col gap-px whitespace-nowrap max-sm:items-center">
                            <p class="text-[#8287AB] text-sm">Должность</p>
                            <div
                                class="px-4 py-1 text-accent bg-[#EFEAE5] shadow-xl shadow-black/25 rounded-sm text-xs">
                                {{ user?.position }}</div>
                        </div>
                        <div class="flex flex-col gap-px whitespace-nowrap items-start max-sm:items-center">
                            <p class="text-[#8287AB] text-sm">Компания</p>
                            <div class="flex gap-2 items-end">
                                <p class="text-dark-blue text-sm">{{ user?.company.name }}</p>
                                <a :href="route('my.company')"
                                    class="p-2 bg-[#EFE9FF] shadow-xl shadow-black/25 rounded-lg hover:scale-90 transition-all duration-500 ease-in-out">
                                    <img class="size-4" :src="external" alt="external" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 w-1/2 max-lg:w-full">
                <div class="flex flex-col gap-3 bg-[#EFEAE5] p-4 rounded-2xl">
                    <div class="flex justify-between max-sm:flex-col max-lg:items-start items-center">
                        <h2 class="font-semibold text-light-gray text-base">Персональные данные</h2>
                        <div class="flex gap-2 whitespace-nowrap items-center">
                            <img class="h-[1cap]" :src="edit" alt="edit" />
                            <button @click="startEditing"
                                class="text-accent cursor-pointer text-xs">Редактировать</button>
                        </div>
                    </div>

                    <div v-if="isEditing" class="mt-4">
                        <div class="flex gap-12">
                            <div class="flex flex-col gap-px justify-end">
                                <p class="text-[#8287AB] text-sm">Имя</p>
                                <input v-model="form.name" type="text"
                                    class="text-dark-blue text-sm border rounded px-2 py-1 outline-none" required />
                            </div>
                            <div class="flex flex-col gap-px justify-end">
                                <p class="text-[#8287AB] text-sm">Фамилия</p>
                                <input v-model="form.surname" type="text"
                                    class="text-dark-blue text-sm border rounded px-2 py-1 outline-none" required />
                            </div>
                        </div>

                        <h2 class="font-semibold text-dark-blue text-base mt-6">Контакты</h2>
                        <div class="flex max-sm:gap-6 max-sm:flex-col gap-12 mt-4">
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-2 flex justify-center items-center size-10 rounded-xl shadow-lg shadow-black/25"
                                    :src="email" alt="email" />
                                <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                    <p class="text-[#8287AB] text-sm">Email</p>
                                    <input v-model="form.email" type="email"
                                        class="text-dark-blue text-sm border rounded px-2 py-1 outline-none" required />
                                </div>
                            </div>
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-2 flex justify-center items-center size-10 rounded-xl shadow-lg shadow-black/25"
                                    :src="phone" alt="phone" />
                                <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                    <p class="text-[#8287AB] text-sm">Телефон</p>
                                    <input v-model="form.phone" type="tel"
                                        class="text-dark-blue text-sm border rounded px-2 py-1 outline-none" required />
                                </div>
                            </div>
                        </div>

                        <h2 class="font-semibold text-dark-blue text-base mt-6">Описание</h2>
                        <textarea v-model="form.info" rows="3"
                            class="text-dark-blue text-sm border rounded px-2 py-1 w-full min-h-[120px] outline-none resize-none"></textarea>

                        <div class="flex justify-end gap-2 mt-6">
                            <button @click="isEditing = false"
                                class="px-4 py-2 bg-gray-300 rounded-full text-sm cursor-pointer">Отмена</button>
                            <button @click="saveChanges"
                                class="px-4 py-2 bg-accent text-white rounded-full text-sm cursor-pointer">Сохранить</button>
                        </div>
                    </div>
                    <div v-else class="flex flex-col gap-3">
                        <div class="flex gap-12">
                            <div class="flex flex-col gap-px justify-end">
                                <p class="text-[#8287AB] text-sm">Имя</p>
                                <p class="text-dark-blue text-sm">{{ user?.name }}</p>
                            </div>
                            <div class="flex flex-col gap-px justify-end">
                                <p class="text-[#8287AB] text-sm">Фамилия</p>
                                <p class="text-dark-blue text-sm">{{ user?.surname }}</p>
                            </div>
                        </div>
                        <h2 class="font-semibold text-dark-blue text-base">Контакты</h2>
                        <div class="flex max-sm:gap-6 max-sm:flex-col gap-12">
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-2 flex justify-center items-center size-10 rounded-xl shadow-lg shadow-black/25"
                                    :src="email" alt="email" />
                                <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                    <p class="text-[#8287AB] text-sm">Email</p>
                                    <a :href="`mailto:${user?.email}`" class="text-dark-blue text-sm">{{
                                        user?.email }}</a>
                                </div>
                            </div>
                            <div class="flex items-end gap-3">
                                <img class="bg-[#EEF0FF] p-2 flex justify-center items-center size-10 rounded-xl shadow-lg shadow-black/25"
                                    :src="phone" alt="phone" />
                                <div class="flex flex-col gap-px whitespace-nowrap justify-end">
                                    <p class="text-[#8287AB] text-sm">Телефон</p>
                                    <a :href="`tel:${user?.phone}`" class="text-dark-blue text-sm">{{
                                        user?.phone }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 v-if="!isEditing" class="font-semibold text-dark-blue text-base">Описание</h2>
                    <p v-if="!isEditing" class="text-dark-blue text-sm">{{ user?.info }}</p>
                </div>
            </div>
        </section>
    </AppLayout>
</template>