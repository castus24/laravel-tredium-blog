<script setup>
import {onMounted, ref} from 'vue'

const chips = ref([])
const tags = ref([])
const loadTags = async () => {
    try {
        const response = await axios.get('api/tags');
        tags.value = response.data.data.map((tag) => tag.label);
    } catch (error) {
        console.log('Tags loading error: ', error)
    }
}

onMounted(loadTags)
</script>

<template>
    <v-item-group selected-class="bg-blue-darken-3" multiple>
        <v-item
            v-for="tag in tags"
            :key="tag"
            v-slot="{ selectedClass, toggle }"
        >
            <v-chip
                :class="selectedClass"
                @click="toggle"
            >
                {{ tag }}
            </v-chip>
        </v-item>
    </v-item-group>
</template>

<style scoped>
.v-chip {
    margin-right: 3px;
    margin-bottom: 3px;
}
</style>
