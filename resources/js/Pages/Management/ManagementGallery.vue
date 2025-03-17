<script setup lang="ts">
import ManagementLayout from "../../Layouts/ManagementLayout.vue";
import { ref, defineProps, onMounted, computed } from "vue";
import axios from "axios";
import TextInput from "../../Components/TextInput.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import UploadNewMedia from "../../Components/UploadNewMedia.vue";
defineOptions({ layout: ManagementLayout });

// UI Elements
const showNewMediaModal = ref<boolean>(false);
const selectedImage = ref<Image | null>(null);

// OBJECTS
interface Image {
    id: number;
    title: string;
    alt_text: string;
    is_public: boolean;
    url: string;
    thumbnail: string;
    medium: string;
}

// PROPS
const props = defineProps<{
    images: Image[];
}>();

/*
 * Sends delete request for given image id.
 *
 */
const deleteImage = async (id: number) => {
    try {
        await axios.delete(`/api/images/${id}`);
        // Refresh the page
        window.location.reload();
    } catch (error) {
        console.error("Failed to delete image", error);
    }
};

onMounted(() => {
    console.log(props.images);
});
</script>
<template>
    <div
        class="mx-auto w-full relative sm:rounded-lg lg:my-8 max-h-full overflow-auto p-8"
    >
        <!-- Header -->
        <div class="mb-8 bg-gray-200 rounded-md flex gap-8 px-4 py-2">
            <div>
                <label for="showAll" class="mr-2">Näytä kaikki</label>
                <input type="checkbox" name="showAll" id="showAll" labe />
            </div>
            <PrimaryButton
                @click.prevent="showNewMediaModal = true"
                class="ml-auto"
                >Tuo Kuvia</PrimaryButton
            >
        </div>

        <!-- Main window -->
        <div class="w-full relative">
            <!-- images -->
            <div class="w-full pr-72 flex gap-4 flex-wrap">
                <div
                    v-for="image in props.images"
                    :key="image.id"
                    @click="selectedImage = image"
                    class=""
                >
                    <img
                        :src="image.thumbnail"
                        :alt="image.alt_text"
                        class="rounded-md object-cover w-48 shadow-md hover:shadow-lg transition-shadow cursor-pointer"
                        loading="lazy"
                    />
                </div>
            </div>
            <!-- right control window -->
            <div
                class="fixed right-4 top-1/2 transform -translate-y-1/2 bg-gray-200 lg:w-72 p-4 shadow-lg rounded-md overflow-auto max-h-screen"
            >
                <div v-if="selectedImage">
                    <img
                        :src="selectedImage.medium"
                        alt="valittu kuva suurempana"
                        class="w-full object-contain"
                    />

                    <div class="mt-4">
                        <label
                            for="imageNameInput"
                            class="block text-sm font-medium"
                            >Nimi</label
                        >
                        <input
                            type="text"
                            id="imageNameInput"
                            :placeholder="selectedImage.title"
                            class="w-full mt-1 rounded-md border-gray-300"
                        />
                    </div>

                    <div class="mt-4">
                        <label
                            for="altTextInput"
                            class="block text-sm font-medium"
                            >alt text</label
                        >
                        <input
                            type="text"
                            id="altTextInput"
                            :placeholder="selectedImage.alt_text"
                            class="w-full mt-1 rounded-md border-gray-300"
                        />
                    </div>

                    <div class="mt-4 flex items-center">
                        <label for="isPublicSelect" class="mr-2"
                            >Näytä kuvissa</label
                        >
                        <input
                            type="checkbox"
                            name="isPublicSelect"
                            id="isPublicSelect"
                            :checked="selectedImage.is_public"
                        />
                    </div>

                    <div>
                        <span
                            class="mt-4 text-red-500 cursor-pointer"
                            @click="deleteImage(selectedImage.id)"
                            >Poista kuva</span
                        >
                    </div>
                </div>

                <div v-if="!selectedImage" class="p-4 text-center">
                    <span class="text-gray-400"
                        >Valitse kuva nähdäksesi tämän tiedot</span
                    >
                </div>
            </div>
        </div>
    </div>

    <div
        v-if="showNewMediaModal"
        class="absolute flex h-dvh w-dvw bg-gray-900 bg-opacity-40 backdrop-blur-sm justify-center items-center top-0 left-0 z-20"
        @click.self="showNewMediaModal = false"
    >
        <div class="md:max-h-[80%] overflow-auto bg-white rounded-md shadow-md">
            <UploadNewMedia :showNewMediaModal="showNewMediaModal" />
        </div>
    </div>
</template>
