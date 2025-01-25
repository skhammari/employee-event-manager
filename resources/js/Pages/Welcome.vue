<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { UserIcon, Cog6ToothIcon } from '@heroicons/vue/20/solid';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="خوش آمدید" />

    <div dir="rtl" class="min-h-screen bg-gray-100">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-indigo-500 selection:text-white">
            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <ApplicationLogo class="w-20 h-20" />
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:left-0 p-6 text-end">
                            <Link
                                v-if="$page.props.auth.member"
                                :href="route('member.dashboard')"
                                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                >داشبورد</Link
                            >

                            <template v-else>
                                <Link
                                    :href="route('member.login')"
                                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                    >ورود اعضا</Link
                                >

                                <Link
                                    :href="route('filament.admin.auth.login')"
                                    class="me-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                    >ورود مدیران</Link
                                >
                            </template>
                        </div>

                        <Link
                            :href="route('member.login')"
                            class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500"
                        >
                            <div>
                                <div class="h-16 w-16 bg-indigo-50 flex items-center justify-center rounded-full">
                                    <UserIcon class="w-7 h-7 text-indigo-500" />
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900">ورود اعضا</h2>

                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    اگر عضو هستید، از اینجا وارد شوید تا بتوانید در رویدادها شرکت کنید و اطلاعات خود را مدیریت کنید.
                                </p>
                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                class="self-center shrink-0 stroke-indigo-500 w-6 h-6 mx-6"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </Link>

                        <Link
                            :href="route('filament.admin.auth.login')"
                            class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-indigo-500"
                        >
                            <div>
                                <div class="h-16 w-16 bg-indigo-50 flex items-center justify-center rounded-full">
                                    <Cog6ToothIcon class="w-7 h-7 text-indigo-500" />
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900">پنل مدیریت</h2>

                                <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                    مدیران سیستم از این قسمت می‌توانند وارد پنل مدیریت شوند و به مدیریت اعضا و رویدادها بپردازند.
                                </p>
                            </div>

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                class="self-center shrink-0 stroke-indigo-500 w-6 h-6 mx-6"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
</style>
