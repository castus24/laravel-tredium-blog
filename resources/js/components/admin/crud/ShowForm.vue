<script setup>
import ImageUpload from "@/components/ui/ImageUpload.vue";

const props = defineProps({
    entity: {
        type: Object,
        required: true,
    },
});

const updateImage = (imageUrl) => {
    if (props.entity.main) {
        props.entity.main = imageUrl
    }
};

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

const emit = defineEmits(['close']);
</script>

<template>
    <v-card class="mx-auto pa-4" min-width="400">
        {{ entity.main_image}}
        <v-img
            v-if="entity.main_image"
            min-height="200"
            :src="entity.main_image"
            cover
        ></v-img>
        <ImageUpload
            v-else
            :entity="entity"
            @image-updated="updateImage"
        />

        <v-divider class="ma-4"></v-divider>

        <v-card-title>Info</v-card-title>
        <v-list v-if="entity">
            <v-list-item
                v-for="(value, key) in entity"
                :key="key"
            >
                <v-list-item-title class="font-weight-bold pb-4">{{ capitalizeFirstLetter(key) }}</v-list-item-title>
                <v-list-item-subtitle>{{ value }}</v-list-item-subtitle>

                <v-divider class="mb-4"></v-divider>
            </v-list-item>
        </v-list>
        <v-card-text v-else>No data</v-card-text>

        <v-card-actions>
            <v-btn color="blue-grey" @click="$emit('close')">Close</v-btn>
        </v-card-actions>
    </v-card>
</template>
