<script setup lang="ts">
import AuthenticatedLayout from "./AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
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
                    :class="{ active: route().current('admin.Dogs') }"
                    :href="route('admin.Dogs')"
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
            </div>

            <!-- Scrollable Main Content -->
            <main class="flex-1 overflow-auto ml-72">
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
