<template>
    <Head title="ورود اعضا" />

    <GuestLayout>
        <div dir="rtl">
            <div class="mb-4 text-sm text-gray-600">
                لطفاً برای دسترسی به پنل اعضا وارد شوید.
            </div>

            <form @submit.prevent="form.post(route('member.login.store'))">
                <div>
                    <InputLabel for="email" value="ایمیل" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="رمز عبور" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="mr-2 text-sm text-gray-600">مرا به خاطر بسپار</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="mr-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        ورود
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});
</script> 