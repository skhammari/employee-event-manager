<template>
    <div ref="qrContainer"></div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import QRCodeStyling from 'qr-code-styling';

const props = defineProps({
    value: {
        type: String,
        required: true,
    },
    options: {
        type: Object,
        default: () => ({}),
    },
});

const qrContainer = ref(null);
let qrCode = null;

const defaultOptions = {
    width: 200,
    height: 200,
    type: 'svg',
    data: props.value,
    dotsOptions: {
        color: '#000000',
        type: 'rounded',
    },
    backgroundOptions: {
        color: '#ffffff',
    },
    cornersSquareOptions: {
        type: 'extra-rounded',
    },
    cornersDotOptions: {
        type: 'dot',
    },
};

onMounted(() => {
    qrCode = new QRCodeStyling({
        ...defaultOptions,
        ...props.options,
    });
    qrCode.append(qrContainer.value);
});

watch(() => props.value, (newValue) => {
    if (qrCode) {
        qrCode.update({
            data: newValue,
        });
    }
});
</script> 