<script setup lang="ts">
import ManagementLayout from "../../Layouts/ManagementLayout.vue";

import TextInput from "../../Components/TextInput.vue";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import UploadIcon from "@/Icons/UploadIcon.vue";
import QuestionIcon from "@/Icons/QuestionIcon.vue";
defineOptions({ layout: ManagementLayout });

interface Dog {
    id: number;
    name: string;
    nickname: string;
}

const props = defineProps<{
    dogs: Dog[];
}>();
interface DogRelationship {
    dog_id: number;
    is_primary: boolean;
    is_secondary: boolean;
}

interface Image {
    image: File;
    title: string;
    alt_text: string;
    is_public: boolean;
    dog_relationships: DogRelationship[];
    preview: string;
}

// To create new Images to media
const newImage = ref<Image>({
    image: new File([], ""),
    title: "",
    alt_text: "",
    is_public: false,
    dog_relationships: [],
    preview: "",
});

// Add dog relationship to image
const newDogRelationsip = ref<Partial<DogRelationship>>({
    dog_id: 0,
    is_primary: false,
    is_secondary: false,
});

// newMedia holds all the media for upload
const newMedia = ref<Image[]>([]);
// errors to be displayed
const errors = ref<any>({});

// Form submission handler
const handleSubmit = async () => {
    try {
        // Validate form
        if (!validateForm()) return;

        // Create FormData object for proper file upload
        const formData = new FormData();

        // Add each image file and its metadata
        newMedia.value.forEach((media, index) => {
            // Add the actual file
            formData.append(`images[${index}][image]`, media.image);

            // Add other properties
            formData.append(`images[${index}][title]`, media.title);
            formData.append(`images[${index}][alt_text]`, media.alt_text);
            formData.append(
                `images[${index}][is_public]`,
                media.is_public ? "1" : "0"
            );

            // Add dog relationships
            media.dog_relationships.forEach((rel, relIndex) => {
                formData.append(
                    `images[${index}][dog_relationships][${relIndex}][dog_id]`,
                    rel.dog_id
                );
                formData.append(
                    `images[${index}][dog_relationships][${relIndex}][is_primary]`,
                    rel.is_primary ? "1" : "0"
                );
                formData.append(
                    `images[${index}][dog_relationships][${relIndex}][is_secondary]`,
                    rel.is_secondary ? "1" : "0"
                );
            });
        });

        // Send FormData to server
        await axios.post("/api/media/store", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        // Show success message
        alert("Media uploaded successfully!");

        // Optionally reset form
        newMedia.value = [];
    } catch (error) {
        console.error("Error uploading media:", error);
    }
};

// Form validation
const validateForm = (): boolean => {
    errors.value = {};
    let isValid = true;

    return isValid;
};
// Add dog relationship to an image
const addDogRelationship = (imageIndex: number, dog: Dog) => {
    console.log("adding dog");

    dogSearchInput.value = "";
    // Check if relationship already exists
    const exists = newMedia.value[imageIndex].dog_relationships.some(
        (rel) => rel.dog_id === dog.id
    );

    if (!exists) {
        console.log("exists: ", exists);
        console.log("Adding new dog: ", dog);
        console.log(
            "previous relationships: ",
            newMedia.value[imageIndex].dog_relationships
        );
        newMedia.value[imageIndex].dog_relationships.push({
            dog_id: dog.id,
            dog_name: dog.name,
            dog_nickname: dog.nickname,
            is_primary: false,
            is_secondary: false,
        });
    }
};

// Remove dog relationship from an image
const removeDogRelationship = (imageIndex: number, dogId: number) => {
    newMedia.value[imageIndex].dog_relationships = newMedia.value[
        imageIndex
    ].dog_relationships.filter((rel) => rel.dog_id !== dogId);
};

// Remove an image from the list
const removeImage = (index: number) => {
    newMedia.value.splice(index, 1);
};
const handleFiles = (event: Event | DragEvent) => {
    console.log("hanling file drop");
    let files: FileList | null = null;

    if (event.type === "drop") {
        event.preventDefault();
        files = (event as DragEvent).dataTransfer?.files || null;
    } else {
        files = (event.target as HTMLInputElement).files;
    }

    if (!files) {
        console.log("no files seen");
        return;
    }

    console.log(files);

    // process files
    Array.from(files).forEach((file) => {
        if (!file.type.startsWith("image/")) return;

        // create preview link
        const reader = new FileReader();
        reader.onload = (e) => {
            newMedia.value.push({
                image: file,
                title: file.name.split(".")[0],
                alt_text: file.name.split(".")[0],
                is_public: false,
                dog_relationships: [],
                preview: e.target?.result as string,
            });
        };

        reader.readAsDataURL(file);
    });

    console.log("new media: ", newMedia);
};

// Handle drag events
const onDragOver = (event: DragEvent) => {
    event.preventDefault();
};

const onDragEnter = (event: DragEvent) => {
    event.preventDefault();
};

const dogSearchInput = ref<string>("");
const isSearchFocused = ref(false);
const dogSearchFilteredDogs = computed((): Dog[] => {
    let filteredDogs: Dog[] = props.dogs.filter(
        (d: Dog) =>
            d.name.toLowerCase().includes(dogSearchInput.value.toLowerCase()) ||
            d.nickname
                .toLowerCase()
                .includes(dogSearchInput.value.toLowerCase())
    );
    return filteredDogs;
});
const handleSearchBlur = () => {
    setTimeout(() => {
        isSearchFocused.value = false;
    }, 100);
};
</script>

<template>
    <div class="max-w-4xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Tuo uusia kuvia</h1>

        <form @submit.prevent="handleSubmit" class="space-y-6">
            <!-- Dropzone -->
            <div
                class="flex items-center justify-center w-full"
                @dragover="onDragOver"
                @dragenter="onDragEnter"
                @drop="handleFiles"
            >
                <label
                    for="dropzone-file"
                    class="flex flex-col select-none items-center justify-center w-full h-64 border shadow-md border-gray-400 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100"
                >
                    <div
                        class="flex flex-col items-center justify-center pt-5 pb-6"
                    >
                        <UploadIcon />
                        <p class="mb-2 text-sm text-gray-500">
                            <span class="font-semibold"
                                >Klikkaa tuodaksesi kuvia</span
                            >
                            tai raahaa kuvat laatikkoon
                        </p>
                        <p class="text-xs text-gray-500">
                            SVG, PNG, JPG (max. 10Mb)
                        </p>
                    </div>
                    <input
                        id="dropzone-file"
                        type="file"
                        class="hidden"
                        multiple
                        accept="image/png, image/jpeg, image/jpg, image/svg+xml"
                        @change="handleFiles"
                    />
                </label>
            </div>

            <!-- Image Preview and Form Fields -->
            <div v-if="newMedia.length > 0" class="space-y-4">
                <h2 class="text-xl font-semibold">
                    Tuodut kuvat ({{ newMedia.length }})
                </h2>

                <div
                    v-for="(image, index) in newMedia"
                    :key="index"
                    class="border rounded-lg p-4 shadow-sm"
                >
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Image Preview -->
                        <div class="w-full md:w-1/3">
                            <div class="relative">
                                <img
                                    :src="image.preview"
                                    alt="Preview"
                                    class="w-full h-40 object-cover rounded-lg"
                                />
                                <button
                                    type="button"
                                    @click="removeImage(index)"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1"
                                    title="Remove image"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-2 text-sm text-gray-500 flex gap-4">
                                {{ image.image.name }} ({{
                                    (image.image.size / 1024).toFixed(0)
                                }}
                                KB)
                                <p
                                    :class="
                                        image.image.size / 1024 < 700
                                            ? 'text-red-500'
                                            : image.image.size / 1024 < 3000
                                            ? 'text-green-400'
                                            : 'text-purple-500'
                                    "
                                >
                                    {{
                                        image.image.size / 1024 < 700
                                            ? "poor quality"
                                            : image.image.size / 1024 < 3000
                                            ? "decent quality"
                                            : "great quality"
                                    }}
                                </p>
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div class="w-full md:w-2/3 space-y-4">
                            <!-- title and alt text -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700"
                                        >Nimi</label
                                    >
                                    <TextInput
                                        v-model="image.title"
                                        class="w-full"
                                        :error="errors[`media.${index}.title`]"
                                    />
                                </div>
                                <div>
                                    <label
                                        class="text-sm font-medium text-gray-700 flex gap-1"
                                        >Vaihtoehtoinen teksti <QuestionIcon />
                                    </label>

                                    <TextInput
                                        v-model="image.alt_text"
                                        class="w-full"
                                        :error="
                                            errors[`media.${index}.alt_text`]
                                        "
                                    />
                                </div>
                            </div>

                            <!-- Check if user wants to place image to public gallery -->
                            <div>
                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        v-model="image.is_public"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                    <span class="ml-2 text-sm text-gray-700"
                                        >Julkinen kuva</span
                                    >
                                </label>
                            </div>

                            <!-- Dog Relationships -->
                            <div v-if="props.dogs && props.dogs.length > 0">
                                <h3
                                    class="text-sm font-medium text-gray-700 mb-1"
                                >
                                    Koirat
                                </h3>

                                <div class="border rounded-md p-3">
                                    <!-- List of dog relationships -->
                                    <div class="mb-4">
                                        <div
                                            v-for="(
                                                dog, dogIndex
                                            ) in image.dog_relationships"
                                            :key="dogIndex"
                                            class="flex gap-4 py-2 flex-wrap w-full justify-between"
                                        >
                                            {{ dog.dog_nickname }}

                                            <!-- Div for buttons  -->
                                            <div class="flex gap-8">
                                                <label
                                                    class="flex items-center"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        v-model="
                                                            image
                                                                .dog_relationships[
                                                                dogIndex
                                                            ].is_primary
                                                        "
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    />
                                                    <span
                                                        class="ml-1 text-xs text-gray-700"
                                                        >Uusi koiran
                                                        profiilikuva</span
                                                    >
                                                </label>
                                                <label
                                                    class="flex items-center"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        v-model="
                                                            image
                                                                .dog_relationships[
                                                                dogIndex
                                                            ].is_secondary
                                                        "
                                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                    />
                                                    <span
                                                        class="ml-1 text-xs text-gray-700"
                                                        >Näytä koiran
                                                        kuvissa</span
                                                    >
                                                </label>

                                                <button
                                                    @click="
                                                        removeDogRelationship(
                                                            index,
                                                            dog.dog_id
                                                        )
                                                    "
                                                >
                                                    X
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dog search -->
                                    <div class="relative">
                                        <TextInput
                                            v-model="dogSearchInput"
                                            placeholder="Etsi koiria..."
                                            class="w-full"
                                            @focus="isSearchFocused = true"
                                            @blur="handleSearchBlur()"
                                        />
                                        <div
                                            v-show="isSearchFocused"
                                            class="mt-2 max-h-60 overflow-auto absolute bg-white border rounded-md w-full z-10"
                                        >
                                            <div
                                                v-for="dog in dogSearchFilteredDogs"
                                                :key="dog.id"
                                                class="flex items-center p-2 gap-2 hover:bg-gray-200 hover:cursor-pointer"
                                                @click.prevent="
                                                    addDogRelationship(
                                                        index,
                                                        dog
                                                    )
                                                "
                                            >
                                                {{ dog.nickname }}
                                                <p class="text-gray-500">
                                                    {{ dog.name }}
                                                </p>
                                            </div>
                                            <div
                                                v-if="
                                                    dogSearchFilteredDogs.length <
                                                    1
                                                "
                                                class="py-2 text-gray-600"
                                            >
                                                Ei koiria haulle
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <button
                    v-if="newMedia.length > 0"
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700"
                >
                    Tallenna kuvat
                </button>
            </div>
        </form>
    </div>
</template>
