<script setup>
import {ref, reactive} from 'vue'
import {useToast} from "vue-toastification";
import AddForm from '@/components/admin/crud/AddForm.vue';
import UpdateForm from "@/components/admin/crud/UpdateForm.vue";
import DeleteForm from "@/components/admin/crud/DeleteForm.vue";
import ShowForm from "@/components/admin/crud/ShowForm.vue";

const articles = ref([])
const selectedArticle = ref(null)
const itemsPerPage = ref(10)
const isLoading = ref(false)
const totalItems = ref(0)
const toast = useToast()

const headers = reactive([
    {title: "ID", key: "id", align: "start"},
    {title: "Title", key: "title", align: "start"},
    {title: "Slug", key: "slug", align: "start"},
    {title: "Published at", key: "published_at", align: "start"},
    {title: "Show", key: "show", align: "center", sortable: false, width: "100px"},
    {title: "Edit", key: "edit", align: "center", sortable: false, width: "100px"},
    {title: "Delete", key: "delete", align: "center", sortable: false, width: "100px"},
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

const openModal = (type, article = null) => {
    selectedArticle.value = article ? {...article} : null;
    modals[type] = true;

    if (type === 'add') {
        formConfig.value = {
            title: 'Add Article',
            fields: [
                {model: 'title', label: 'Title', type: 'text'},
                {model: 'content', label: 'Content', type: 'textarea'},
            ],
        };
    }
};

const closeModal = (type) => {
    selectedArticle.value = null;
    modals[type] = false;
};

const loadArticles = async ({page, itemsPerPage, sortBy}) => {
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
        const response = await axios.get("/api/articles", {params})
        const {data, meta} = response.data
        articles.value = data
        totalItems.value = meta.total
    } catch (error) {
        console.error("Error loading articles:", error)
    } finally {
        isLoading.value = false
    }
};

const addArticle = async (article) => {
    try {
        const {data} = await axios.post(`/api/articles`, article)
        articles.value.push(data.data)
        closeModal('add')
        toast.success(data.message)
    } catch (error) {
        console.error("Error adding article:", error)
        const errorMessage = error.response?.error || 'Error adding article';
        toast.error(errorMessage)
    }
}

//todo check need request to api
const showArticle = async (article) => {
    try {
        const {data} = await axios.get(`/api/articles/${article.slug}`)
        articles.value = data.data
        closeModal('show')
        toast.success(data.message)
    } catch (error) {
        console.error("Error showing article:", error)
        const errorMessage = error.response?.error || 'Error showing article';
        toast.error(errorMessage)
    }
}

const updateArticle = async (updatedArticle) => {
    try {
        const {data} = await axios.put(`/api/articles/${updatedArticle.slug}`, updatedArticle)
        const index = articles.value.findIndex((article) => article.slug === updatedArticle.slug)
        if (index !== -1) articles.value.splice(index, 1, data.data)
        closeModal('update')
        toast.success(data.message)

    } catch (error) {
        console.error("Error updating article:", error)
        const errorMessage = error.response?.error || 'Error updating article';
        toast.error(errorMessage)
    }
}

const deleteArticle = async (articleForDelete) => {
    try {
        const {data} = await axios.delete(`/api/articles/${articleForDelete.slug}`)
        articles.value = articles.value.filter((article) => article.slug !== articleForDelete.slug)
        closeModal('delete')
        toast.success(data.message)
    } catch (error) {
        console.error("Error deleting article:", error)
        const errorMessage = error.response?.error || 'Error deleting article';
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
            Add Article
        </v-btn>

        <v-card elevation="5">
            <v-data-table-server
                v-model:items-per-page="itemsPerPage"
                :headers="headers"
                :items="articles"
                :items-length="totalItems"
                :loading="isLoading"
                @update:options="loadArticles"
            >
                <template #item.show="{ item }">
                    <v-btn color="info"
                           variant="tonal"
                           @click="openModal('show', item)"
                    >
                        <v-icon>mdi-eye</v-icon>
                    </v-btn>
                </template>

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
                @save="addArticle"
                @close="closeModal('add')"
            />
        </v-dialog>

        <v-dialog v-model="modals.show" max-width="500px">
            <ShowForm
                v-if="selectedArticle"
                :entity="selectedArticle"
                @close="closeModal('show')"
            />
        </v-dialog>

        <v-dialog v-model="modals.update" max-width="500px">
            <UpdateForm
                v-if="selectedArticle"
                :title="'Update Article'"
                :entity="selectedArticle"
                :fields="[
                    { model: 'title', label: 'Title', type: 'text' },
                    { model: 'content', label: 'Content', type: 'textarea' },
                ]"
                @save="updateArticle"
                @close="closeModal('update')"
            />
        </v-dialog>

        <v-dialog v-model="modals.delete" max-width="500px">
            <DeleteForm
                v-if="selectedArticle"
                :title="'Delete Article'"
                :entity="selectedArticle"
                :entityTitleKey="'title'"
                :message="'Are you sure you want to delete the article:'"
                @delete="deleteArticle"
                @close="closeModal('delete')"
            />
        </v-dialog>
    </v-container>
</template>
