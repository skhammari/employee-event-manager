<template>
    <Head title="داشبورد" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">داشبورد</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Member Info Card -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">اطلاعات عضویت</h2>
                                <p class="mt-1 text-sm text-gray-600">اطلاعات شخصی و کد QR شما</p>
                            </header>

                            <div class="mt-6 space-y-6">
                                <div>
                                    <div class="text-sm text-gray-600">نام:</div>
                                    <div class="text-base">{{ member.name }}</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-600">کد عضویت:</div>
                                    <div class="text-base">{{ member.personal_id }}</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-600">ایمیل:</div>
                                    <div class="text-base">{{ member.email }}</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-600">تلفن:</div>
                                    <div class="text-base">{{ member.phone || '---' }}</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-600">آدرس:</div>
                                    <div class="text-base">{{ member.address || '---' }}</div>
                                </div>

                                <div>
                                    <div class="text-sm text-gray-600 mb-2">کد QR:</div>
                                    <div class="bg-white p-4 inline-block rounded-lg shadow">
                                        <img :src="member.qr_code" alt="QR Code" class="w-32 h-32">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Event Participations -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900">رویدادهای من</h2>
                                <p class="mt-1 text-sm text-gray-600">رویدادهایی که در آنها ثبت‌نام کرده‌اید</p>
                            </header>

                            <div class="mt-6">
                                <div v-if="participations.length === 0" class="text-gray-500 text-center py-4">
                                    شما هنوز در هیچ رویدادی ثبت‌نام نکرده‌اید.
                                    <Link :href="route('member.events')" class="text-indigo-600 hover:text-indigo-500 mr-2">
                                        مشاهده رویدادها
                                    </Link>
                                </div>

                                <div v-else class="space-y-4">
                                    <div v-for="participation in participations" :key="participation.id" 
                                        class="border rounded-lg p-4">
                                        <div class="font-medium">{{ participation.event.title }}</div>
                                        <div class="text-sm text-gray-600 mt-1">
                                            {{ new Date(participation.event.start_date).toLocaleDateString('fa-IR') }} - 
                                            {{ new Date(participation.event.end_date).toLocaleDateString('fa-IR') }}
                                        </div>
                                        <div class="text-sm mt-1">
                                            <span class="text-gray-600">وضعیت: </span>
                                            <span :class="{
                                                'text-green-600': participation.is_validated,
                                                'text-yellow-600': !participation.is_validated
                                            }">
                                                {{ participation.is_validated ? 'تایید شده' : 'در انتظار تایید' }}
                                            </span>
                                        </div>
                                        <div v-if="!participation.is_validated" class="text-sm mt-1">
                                            <span class="text-gray-600">کد تایید: </span>
                                            <span class="font-mono">{{ participation.validation_code }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    member: {
        type: Object,
        required: true,
    },
    participations: {
        type: Array,
        required: true,
    },
});
</script> 