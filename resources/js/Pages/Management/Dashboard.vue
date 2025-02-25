<script setup lang="ts">
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import ManagementLayout from "../../Layouts/ManagementLayout.vue";

import TextInput from "../../Components/TextInput.vue";
import { ref, defineProps, onMounted, computed } from "vue";
import axios from "axios";
defineOptions({ layout: ManagementLayout });
</script>

<template>
    <div class="p-4">
        <h3>Dashboard</h3>
    </div>
</template>
