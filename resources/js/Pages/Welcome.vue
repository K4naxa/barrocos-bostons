<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";
import CombinedLayout from "../Layouts/CombinedLayout.vue";
import GuestLayout from "../Layouts/GuestLayout.vue";

defineOptions({ layout: CombinedLayout });
</script>

<template>
    <Head title="Etusivu" />

    this is our home PAGE
</template>
