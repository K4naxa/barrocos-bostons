<script setup lang="ts">
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
</script>
<template>
    <div class="flex">
        <!-- Menu -->
        <div class="w-96">
            <Link
                :href="route('admin.Dogs')"
                :active="route().current('admin.Dogs')"
            >
                Koirat
            </Link>
            <!-- <NavLink :href="router(dog.create)">Luo koira</NavLink> -->
        </div>
        <div class="w-full">
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
