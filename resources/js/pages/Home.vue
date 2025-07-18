<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <section class="secContent background-pages">
        <div class="dvContent presentationBox mx-16 flex items-center justify-center">
            <div class="presentation">
                <h1>Bem Vindo</h1>
                <h2>App Dashboard</h2>
                <h2>Pix Payments</h2>
                <h3 class="mt-[2vw]">Gerenciamento de login, geração de pix, visualização de números</h3>
            </div>
        </div>
        <div
            class="dvContent opacity-[0.97] mx-4 flex min-h-screen min-w-[30%] items-center justify-center bg-white dark:bg-[#1b1b18]">
            <div class="interactBox mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">

                <div class="interact-background interactBox">

                    <nav class="interact-items flex items-center justify-end gap-4">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                        Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="route('login')"
                                class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]">
                            Log in
                            </Link>
                            <Link :href="route('register')"
                                class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
                            Register
                            </Link>
                        </template>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</template>