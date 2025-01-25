<template>
    <Head title="رویدادها" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">رویدادها</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ $page.props.flash.success }}
                        </div>
                        <div v-if="$page.props.flash?.error" class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            {{ $page.props.flash.error }}
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium">رویدادهای فعال</h3>
                            <p class="text-sm text-gray-600">
                                شما می‌توانید حداکثر در ۳ رویداد شرکت کنید.
                                تعداد رویدادهای فعلی شما: {{ currentParticipations }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div v-for="event in events" :key="event.id" 
                                class="bg-white rounded-lg border p-6">
                                <h4 class="font-semibold text-lg mb-2">{{ event.title }}</h4>
                                <p class="text-sm text-gray-600 mb-4">{{ event.description }}</p>
                                
                                <div class="text-sm mb-2">
                                    <div class="flex justify-between mb-1">
                                        <span>تاریخ شروع:</span>
                                        <span>{{ new Date(event.start_date).toLocaleDateString('fa-IR') }}</span>
                                    </div>
                                    <div class="flex justify-between mb-1">
                                        <span>تاریخ پایان:</span>
                                        <span>{{ new Date(event.end_date).toLocaleDateString('fa-IR') }}</span>
                                    </div>
                                    <div class="flex justify-between mb-1">
                                        <span>مکان:</span>
                                        <span>{{ event.location || '---' }}</span>
                                    </div>
                                    <div class="flex justify-between mb-1">
                                        <span>ظرفیت باقیمانده:</span>
                                        <span>{{ event.remaining_spaces }} / {{ event.participation_limit }}</span>
                                    </div>
                                </div>

                                <form @submit.prevent="form.post(route('member.events.participate', event.id))">
                                    <PrimaryButton 
                                        :disabled="!canParticipate || form.processing || event.remaining_spaces === 0"
                                        class="w-full justify-center"
                                    >
                                        {{ event.remaining_spaces === 0 ? 'ظرفیت تکمیل' : 'ثبت‌نام' }}
                                    </PrimaryButton>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    events: {
        type: Array,
        required: true,
    },
    canParticipate: {
        type: Boolean,
        required: true,
    },
    currentParticipations: {
        type: Number,
        required: true,
    },
});

const form = useForm({});
</script> 