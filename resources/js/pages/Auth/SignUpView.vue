<script setup>
import { ref, computed, onMounted } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, usePage } from '@inertiajs/vue3'

// IMAGES
import addImage from '@/assets/images/icons/add_image.svg'

const companies = computed(() => usePage().props.companies)
const previewImage = ref('')
const userInput = ref('');
const error = ref(false)
const captchaRef = ref(null)
const captchaCanvas = ref(null)
let captchaCode = ''

const form = useForm({
    name: '',
    surname: '',
    email: '',
    phone: '',
    company_id: null,
    position: '',
    info: '',
    password: '',
    password_confirmation: '',
    avatar: null,
    privacy: false,
    captcha: '',
})

const onAvatarChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        const reader = new FileReader()
        reader.onload = (e) => {
            previewImage.value = e.target.result
        }
        reader.readAsDataURL(file)
        form.avatar = file
    }
}

const generateRandomCode = (length = 6) => {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
    let code = ''
    for (let i = 0; i < length; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length))
    }
    return code
}

const drawCaptcha = (code) => {
    const canvas = captchaCanvas.value
    const ctx = canvas.getContext('2d')
    if (!ctx) return
    ctx.clearRect(0, 0, canvas.width, canvas.height)
    ctx.fillStyle = '#f0f0f0'
    ctx.fillRect(0, 0, canvas.width, canvas.height)
    ctx.font = '1rem Arial'
    ctx.fillStyle = '#000'
    ctx.textAlign = 'center'
    ctx.textBaseline = 'bottom'
    ctx.fillText(code, canvas.width / 2, canvas.height / 2 + 10)

    for (let i = 0; i < 5; i++) {
        ctx.beginPath()
        ctx.moveTo(Math.random() * canvas.width, Math.random() * canvas.height)
        ctx.lineTo(Math.random() * canvas.width, Math.random() * canvas.height)
        ctx.strokeStyle = '#ccc'
        ctx.stroke()
    }

    for (let i = 0; i < 50; i++) {
        ctx.fillStyle = '#000'
        ctx.fillRect(
            Math.random() * canvas.width,
            Math.random() * canvas.height,
            1,
            1
        )
    }
}

const validateCaptcha = () => {
    if (userInput.value.trim().toLowerCase() === captchaCode.toLowerCase()) {
        error.value = false
    } else {
        error.value = true
    }
}

const refreshCaptcha = () => {
    captchaCode = generateRandomCode()
    drawCaptcha(captchaCode)
    userInput.value = ''
    error.value = false
}

onMounted(() => {
    refreshCaptcha()
})

const submitForm = () => {
    const input = userInput.value.trim().toLowerCase()

    if (!input) {
        alert('Пожалуйста, введите капчу')
        return
    }

    if (input !== captchaCode.toLowerCase()) {
        alert('Неверный код капчи!')
        refreshCaptcha()
        return
    }

    form.captcha = input

    const data = new FormData()
    data.append('name', form.name)
    data.append('surname', form.surname)
    data.append('email', form.email)
    data.append('phone', form.phone)
    data.append('company_id', form.company_id)
    data.append('position', form.position)
    data.append('info', form.info ?? '')
    data.append('password', form.password)
    data.append('password_confirmation', form.password_confirmation)
    data.append('privacy', form.privacy ? '1' : '0')
    data.append('captcha', input)

    if (form.avatar) {
        data.append('avatar', form.avatar)
    }

    form.post(route('register'), {
        data: data,
        preserveScroll: true,
        onSuccess: () => {
            alert('Регистрация прошла успешно!')
        },
        onError: (errors) => {
            console.log(errors)
        },
    })
}
</script>

<template>
    <AppLayout
        class="flex flex-col items-center justify-center min-h-dvh ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:max-xl:w-full max-lg:ml-0">
        <div class="flex items-center justify-center duration-500">
            <div
                class="bg-white rounded-2xl shadow-[7px_7px_5px_#00000040] h-auto flex justify-center items-center my-12 p-8 max-lg:p-4 w-full">
                <div class="flex justify-center items-center flex-col gap-6 w-full">
                    <h1 class="font-alumini text-3xl tracking-wider">Регистрация</h1>
                    <form @submit.prevent="submitForm" class="flex gap-12 w-full items-center">
                        <div class="flex flex-col justify-start items-center gap-3">
                            <div
                                class="relative size-16 rounded-full overflow-hidden flex justify-center items-center border-2 transition-all duration-500 ease-in-out hover:border-accent border-black cursor-pointer">
                                <img :src="previewImage || addImage" alt="Аватар"
                                    :class="previewImage ? 'size-full' : 'size-6'" class="object-cover object-center" />
                                <input required type="file" @change="onAvatarChange" accept="image/*"
                                    class="w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer" />
                            </div>
                            <input placeholder="Имя" v-model="form.name"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                                autocomplete="off" required type="text" />
                            <input placeholder="Фамилия" v-model="form.surname"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                                autocomplete="off" required type="text" />
                            <input placeholder="Телефон" v-model="form.phone"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                                autocomplete="off" required type="tel" />
                            <select v-model="form.company_id"
                                class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer w-full"
                                required>
                                <option disabled value="">Выберите компанию</option>
                                <option v-for="company in companies" :key="company.id" :value="company.id">{{
                                    company.name }}</option>
                            </select>
                            <input placeholder="Почта" v-model="form.email"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                                autocomplete="off" required type="email" />
                            <input placeholder="Пароль" v-model="form.password"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                                autocomplete="off" required type="password" />
                            <input placeholder="Повторить пароль" v-model="form.password_confirmation"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none px-2"
                                autocomplete="off" required type="password" />
                            <select v-model="form.position"
                                class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer w-full"
                                required>
                                <option disabled value="">Выберите должность</option>
                                <option value="Грузовладелец">Грузовладелец</option>
                                <option value="Диспетчер">Диспетчер</option>
                            </select>
                        </div>
                        <div class="flex flex-col justify-start items-center gap-3">
                            <textarea v-model="form.info" placeholder="Дополнительная информация" rows="4"
                                class="text-light-gray border w-full resize-none border-light-gray rounded-lg outline-none text-sm py-2 px-3"
                                required></textarea>
                            <label class="flex cursor-pointer items-center justify-start gap-x-2 p-1 text-light-gray">
                                <div class="relative flex items-center">
                                    <input v-model="form.privacy" required
                                        class="peer h-6 w-12 cursor-pointer appearance-none rounded-full border border-gray-300 checked:border-text-accent focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-dark-blue focus-visible:ring-offset-2"
                                        type="checkbox" />
                                    <span
                                        class="pointer-events-none absolute left-1 top-1 block h-4 w-4 rounded-full bg-light-gray transition-all duration-200 peer-checked:left-7 peer-checked:bg-accent"></span>
                                </div>
                                <div class="flex justify-center gap-1 items-center whitespace-nowrap">
                                    <p>Я согласен с</p>
                                    <a :href="route('privacy')" class="font-light italic group">
                                        <span class="transition-all duration-500 hover:text-accent">Политикой
                                            сервиса</span>
                                    </a>
                                </div>
                            </label>
                            <div class="flex flex-col justify-center items-center gap-2 relative">
                                <div class="flex flex-col gap-1 items-start">
                                    <input required
                                        class="outline-none py-1 px-2 border-accent border rounded-lg w-full"
                                        id="captchaInput" v-model="userInput" @input="validateCaptcha"
                                        placeholder="Код" />
                                    <p v-if="error" class="text-red-500 text-sm text-center">Неверный код!</p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <canvas class="border border-accent" ref="captchaCanvas" width="100"
                                        height="40"></canvas>
                                    <button class="cursor-pointer" @click="refreshCaptcha">Обновить</button>
                                </div>
                            </div>
                            <button type="submit"
                                class="px-8 py-1 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Зарегистрироваться</button>
                            <div class="flex justify-center gap-1 items-center whitespace-nowrap">
                                <p>Вы не в первый раз? </p>
                                <a :href="route('login')" class="font-semibold group">
                                    <span class="transition-all duration-500 hover:text-accent">Войти в аккаунт</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>