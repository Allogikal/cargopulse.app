<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import Swal from 'sweetalert2'

const form = useForm({
    email: '',
    password: '',
})

const submitForm = () => {
    form.post(route('login'), {
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Успешный вход",
                showConfirmButton: false,
                timer: 2000
            });
        },
        onError: (errors) => {
            if (errors.email) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: errors.email,
                    showConfirmButton: false,
                    timer: 2500
                });
            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Произошла ошибка. Проверьте правильность ввода.",
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        }
    });
}
</script>

<template>
    <AppLayout
        class="flex flex-col items-center justify-center min-h-dvh ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:max-xl:w-full max-lg:ml-0">
        <div class="flex items-center justify-center duration-500">
            <div
                class="bg-white rounded-2xl shadow-[7px_7px_5px_#00000040] h-auto flex justify-center items-center p-18 max-sm:p-4 w-full">
                <div class="flex justify-center items-center flex-col gap-6 w-full">
                    <h1 class="font-alumini text-3xl tracking-wider">Авторизация</h1>
                    <form class="flex flex-col gap-3 w-full" @submit.prevent="submitForm">
                        <input placeholder="Почта" v-model="form.email" id="email"
                            class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                            autocomplete="off" required type="email" />
                        <input placeholder="Пароль" v-model="form.password" id="password"
                            class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                            autocomplete="off" required type="password" />
                        <button type="submit"
                            class="px-8 py-1 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Войти</button>
                        <div class="flex justify-center gap-1 items-center whitespace-nowrap">
                            <p>Вы первый раз? </p>
                            <a :href="route('register')" class="font-semibold group">
                                <span class="transition-all duration-500 hover:text-accent">Создать аккаунт</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>