<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import gsap from 'gsap'
import burgerIcon from '@/assets/images/icons/burger.svg'
import logotype from '@/assets/images/icons/logotype.svg'

const mobileMenu = ref(null)
const overlay = ref(null)
const burger = ref(null)
const user = computed(() => usePage().props.auth.user)
let isMenuOpen = false

const openMenu = () => {
  if (!mobileMenu.value || !overlay.value || !burger.value) return

  burger.value.classList.add('active', 'burger-active')
  gsap.to(mobileMenu.value, { x: 0, duration: 0.5, ease: 'power3.inOut' })
  gsap.to(overlay.value, { autoAlpha: 1, duration: 0.3 })
  document.body.style.overflow = 'hidden'
}

const closeMenu = () => {
  if (!mobileMenu.value || !overlay.value || !burger.value) return

  burger.value.classList.remove('active', 'burger-active')
  gsap.to(mobileMenu.value, { x: '100%', duration: 0.5, ease: 'power3.inOut' })
  gsap.to(overlay.value, { autoAlpha: 0, duration: 0.3 })
  document.body.style.overflow = ''
}

const toggleMenu = () => {
  isMenuOpen = !isMenuOpen
  isMenuOpen ? openMenu() : closeMenu()
}

onMounted(() => {
  if (mobileMenu.value && overlay.value && burger.value) {
    gsap.set(mobileMenu.value, { x: '100%' })
    gsap.set(overlay.value, { autoAlpha: 0 })

    mobileMenu.value.querySelectorAll('a').forEach(link =>
      link.addEventListener('click', closeMenu)
    )
    overlay.value.addEventListener('click', closeMenu)

    window.addEventListener('resize', () => {
      if (window.innerWidth > 1024) closeMenu()
    })
  }
})

onUnmounted(() => {
  if (mobileMenu.value) {
    mobileMenu.value.querySelectorAll('a').forEach(link =>
      link.removeEventListener('click', closeMenu)
    )
  }

  if (overlay.value) {
    overlay.value.removeEventListener('click', closeMenu)
  }

  window.removeEventListener('resize', () => {
    if (window.innerWidth > 1024) closeMenu()
  })
})
</script>

<template>
  <header
    class="fixed top-0 left-0 w-1/5 max-xl:w-1/4 h-screen bg-dark-blue max-lg:bg-transparent rounded-r-3xl pt-16 text-base max-w-[320px] 3xl:w-1/6 z-40 min-h-screen">
    <nav class="flex flex-col gap-8 max-lg:hidden">
      <div
        class="flex max-lg:flex-col gap-4 font-semibold text-3xl font-serif items-center justify-start tracking-wider pl-4 max-lg:pl-0">
        <img :src="logotype" alt="logotype" />
        <div class="flex gap-2 max-2xl:text-2xl">
          <p class="text-light-gray">Cargo</p>
          <p class="text-white">Pulse</p>
        </div>
      </div>

      <ul class="flex flex-col items-start gap-2 max-lg:gap-px">
        <li class="w-full">
          <a :href="route('profile')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Профиль</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('my.company')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Моя компания</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('cargos')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Грузы</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('transport')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Транспорт</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('applications')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Заявки</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('companies')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Компании</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('news')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Новости</p>
          </a>
        </li>
        <li class="w-full" v-if="user?.is_admin">
          <a :href="route('users')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out relative group flex py-3">
            <span
              class="bg-accent transform -translate-x-100 3xl:-translate-x-full active:-translate-x-12 active:scale-x-106 group-focus:-translate-x-12 group-focus:scale-x-106 group-hover:-translate-x-12 group-hover:scale-x-106 transition-all duration-500 ease-in-out absolute inset-0 z-0 rounded-r-xl"></span>
            <p class="relative z-10 pl-12 group-focus:text-black">Пользователи</p>
          </a>
        </li>
      </ul>
    </nav>

    <!-- Mobile menu -->
    <div id="mobile-menu" ref="mobileMenu"
      class="fixed flex flex-col items-center justify-center right-0 top-0 h-screen w-1/3 max-sm:gap-6 rounded-l-2xl max-sm:w-3/4 text-white bg-dark-blue transform translate-x-full transition-transform duration-700 ease-in-out z-40">
      <div
        class="flex flex-col gap-4 font-semibold text-3xl font-serif items-center justify-center tracking-wider pl-4">
        <img src="../assets/images/icons/logotype.svg" alt="logotype" />
        <div class="flex gap-2 max-2xl:text-2xl">
          <p class="text-light-gray">Cargo</p>
          <p class="text-white">Pulse</p>
        </div>
      </div>

      <ul class="flex flex-col items-center gap-2 max-lg:gap-px">
        <li class="w-full">
          <a :href="route('profile')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Профиль</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('my.company')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Компания</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('cargos')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Грузы</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('transport')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Транспорт</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('applications')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Заявки</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('companies')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Компании</p>
          </a>
        </li>
        <li class="w-full">
          <a :href="route('news')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Новости</p>
          </a>
        </li>
        <li class="w-full" v-if="user?.is_admin">
          <a :href="route('users')"
            class="text-white hover:text-dark-border transition-all duration-700 ease-in-out flex py-3">
            <p>Пользователи</p>
          </a>
        </li>
      </ul>
    </div>

    <div id="overlay" ref="overlay"
      class="fixed inset-0 bg-black/50 w-screen min-h-screen z-20 opacity-0 transition-opacity duration-300">
    </div>

    <button ref="burger" @click="toggleMenu" class="cursor-pointer burger absolute left-6 top-6 lg:hidden">
      <img class="size-8" :src="burgerIcon" alt="burger" />
    </button>
  </header>
</template>