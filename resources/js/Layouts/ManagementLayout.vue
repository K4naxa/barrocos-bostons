<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "./AuthenticatedLayout.vue";
</script>

<template>
    <Head title="Hallinta" />
    <AuthenticatedLayout>
        <div class="flex flex-1 overflow-hidden">
            <!-- Fixed Menu -->
            <div class="w-72 border-r flex flex-col shadow-md fixed h-dvh">
                <Link
                    class="navlink"
                    :class="{ active: route().current('admin.dashboard') }"
                    :href="route('admin.dashboard')"
                >
                    Dashboard
                </Link>
                <Link
                    class="navlink"
                    :class="{ active: route().current('admin.dogs') }"
                    :href="route('admin.dogs')"
                >
                    Koirat
                </Link>
                <Link
                    class="navlink"
                    :class="{ active: route().current('dog.create') }"
                    :href="route('dog.create')"
                >
                    Luo Koira
                </Link>
                <Link
                    class="navlink"
                    :class="{
                        active: route().current('admin.managementGallery'),
                    }"
                    :href="route('admin.managementGallery')"
                >
                    Kuvat
                </Link>
            </div>

            <!-- Scrollable Main Content -->
            <main class="ml-72 w-full">
                <slot />
            </main>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.navlink {
    @apply border-b border-gray-200 py-4 transition-colors duration-100 px-6 hover:bg-gray-200;
}
/* Target active link */
.navlink.active {
    @apply bg-blue-200; /* Ensures background color */
}
/* Optional: Change hover color when active */
.navlink.active:hover {
    @apply bg-blue-300;
}
</style>
