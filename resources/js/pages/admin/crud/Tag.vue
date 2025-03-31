<script setup>
import {ref, reactive} from 'vue'
import {useToast} from "vue-toastification";
import AddForm from "@/components/admin/crud/AddForm.vue";
import UpdateForm from "@/components/admin/crud/UpdateForm.vue";
import DeleteForm from "@/components/admin/crud/DeleteForm.vue";

const tags = ref([])
const selectedTag = ref(null)
const itemsPerPage = ref(10)
const isLoading = ref(false)
const totalItems = ref(0)
const toast = useToast()

const headers = reactive([
    {title: "ID", key: "id", align: "start"},
    {title: "Label", key: "label", align: "start"},
    {title: "Edit", key: "edit", align: "center", sortable: false},
    {title: "Delete", key: "delete", align: "center", sortable: false},
]);

const modals = reactive({
    add: false,
    show: false,
    update: false,
    delete: false,
});

const formConfig = ref({
    title: '',
    fields: [],
});

const openModal = (type, tag = null) => {
    selectedTag.value = tag ? { ...tag } : null;
    modals[type] = true;

    if (type === 'add') {
        formConfig.value = {
            title: 'Add Tag',
            fields: [
                { model: 'label', label: 'Label', type: 'text' },
            ],
        };
    }
};

const closeModal = (type) => {
    selectedTag.value = null;
    modals[type] = false;
};

const loadTags = async ({page, itemsPerPage, sortBy}) => {
    isLoading.value = true

    const sortParam = sortBy?.length
        ? sortBy.map((sort) => (sort.order === "desc" ? `-${sort.key}` : sort.key)).join(",")
        : "";

    const params = {
        page,
        itemsPerPage,
        sort: sortParam,
    };

    try {
        const response = await axios.get("/api/tags", {params})
        const {data, meta} = response.data
        tags.value = data
        totalItems.value = meta.total
    } catch (error) {
        console.error("Error loading tags:", error)
    } finally {
        isLoading.value = false
    }
};

const addTag = async (tag) => {
    try {
        const {data} = await axios.post(`/api/tags`, tag)
        tags.value.push(data.data)
        closeModal('add')
        toast.success(data.message)
    } catch (error) {
        console.error("Error adding tag:", error)
        const errorMessage = error.response?.error || 'Error adding tag';
        toast.error(errorMessage)
    }
}

const updateTag = async (updatedTag) => {
    try {
        const {data} = await axios.put(`/api/tags/${updatedTag.id}`, updatedTag)
        const index = tags.value.findIndex((tag) => tag.id === updatedTag.id)
        if (index !== -1) tags.value.splice(index, 1, data.data)
        closeModal('update')
        toast.success(data.message)

    } catch (error) {
        console.error("Error updating tag:", error)
        const errorMessage = error.response?.error || 'Error updating tag';
        toast.error(errorMessage)
    }
}

const deleteTag = async (tagForDelete) => {
    try {
        const {data} = await axios.delete(`/api/tags/${tagForDelete.id}`)
        tags.value = tags.value.filter((tag) => tag.id !== tagForDelete.id)
        closeModal('delete')
        toast.success(data.message)
    } catch (error) {
        console.error("Error deleting tag:", error)
        const errorMessage = error.response?.error || 'Error deleting tag';
        toast.error(errorMessage)
    }
}
</script>

<template>
    <v-container>
        <v-btn
            color="success"
            variant="tonal"
            class="mb-5"
            @click="openModal('add')"
        >
            Add Tag
        </v-btn>

        <v-card elevation="5">
            <v-data-table-server
                v-model:items-per-page="itemsPerPage"
                :headers="headers"
                :items="tags"
                :items-length="totalItems"
                :loading="isLoading"
                @update:options="loadTags"
            >
                <template #item.edit="{ item }">
                    <v-btn
                        color="warning"
                        variant="tonal"
                        @click="openModal('update', item)"
                    >
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                </template>

                <template #item.delete="{ item }">
                    <v-btn
                        color="red"
                        variant="tonal"
                        @click="openModal('delete', item)"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </template>
            </v-data-table-server>
        </v-card>

        <v-dialog v-model="modals.add" max-width="500px">
            <AddForm
                :title="formConfig.title"
                :fields="formConfig.fields"
                @save="addTag"
                @close="closeModal('add')"
            />
        </v-dialog>

        <v-dialog v-model="modals.update" max-width="500px">
            <UpdateForm
                v-if="selectedTag"
                :title="'Update Tag'"
                :entity="selectedTag"
                :fields="[
                    { model: 'label', label: 'Label', type: 'text' },
                ]"
                @save="updateTag"
                @close="closeModal('update')"
            />
        </v-dialog>

        <v-dialog v-model="modals.delete" max-width="500px">
            <DeleteForm
                v-if="selectedTag"
                :title="'Delete Tag'"
                :entity="selectedTag"
                :entityTitleKey="'label'"
                :message="'Are you sure you want to delete the tag:'"
                @delete="deleteTag"
                @close="closeModal('delete')"
            />
        </v-dialog>
    </v-container>
</template>
