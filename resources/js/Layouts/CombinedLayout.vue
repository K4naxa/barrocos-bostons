<template>
    <AuthenticatedLayout>
        <GuestLayout>
            <slot />
        </GuestLayout>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "./AuthenticatedLayout.vue";
import GuestLayout from "./GuestLayout.vue";
</script>
