<script setup>
import {ref, reactive} from 'vue'
import {useToast} from "vue-toastification";
import AddForm from "@/components/admin/crud/AddForm.vue";
import UpdateForm from "@/components/admin/crud/UpdateForm.vue";
import DeleteForm from "@/components/admin/crud/DeleteForm.vue";

const permissions = ref([])
const selectedPermission = ref(null)
const itemsPerPage = ref(10)
const isLoading = ref(false)
const totalItems = ref(0)
const toast = useToast()

const headers = reactive([
    {title: "ID", key: "id", align: "start"},
    {title: "Name", key: "name", align: "start"},
    {title: "Guard", key: "guard_name", align: "start"},
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
    selectedPermission.value = tag ? { ...tag } : null;
    modals[type] = true;

    if (type === 'add') {
        formConfig.value = {
            title: 'Add Permission',
            fields: [
                { model: 'name', label: 'Name', type: 'text' },
                { model: 'guard_name', label: 'Guard', type: 'text' },
            ],
        };
    }
};

const closeModal = (type) => {
    selectedPermission.value = null;
    modals[type] = false;
};

const loadPermissions = async ({page, itemsPerPage, sortBy}) => {
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
        const response = await axios.get("/api/permissions/list", {params})
        const {data, meta} = response.data
        permissions.value = data
        totalItems.value = meta.total
    } catch (error) {
        console.error("Error loading permissions:", error)
    } finally {
        isLoading.value = false
    }
};

const addPermission = async (permission) => {
    try {
        const {data} = await axios.post(`/api/permissions`, permission)
        permissions.value.push(data.data)
        closeModal('add')
        toast.success(data.message)
    } catch (error) {
        console.error("Error adding permission:", error)
        const errorMessage = error.response?.error || 'Error adding permission';
        toast.error(errorMessage)
    }
}

const updatePermission = async (updatedPermission) => {
    try {
        const {data} = await axios.put(`/api/permissions/${updatedPermission.id}`, updatedPermission)
        const index = permissions.value.findIndex((permission) => permission.id === updatedPermission.id)
        if (index !== -1) permissions.value.splice(index, 1, data.data)
        closeModal('update')
        toast.success(data.message)

    } catch (error) {
        console.error("Error updating permission:", error)
        const errorMessage = error.response?.error || 'Error updating permission';
        toast.error(errorMessage)
    }
}

const deletePermission = async (permissionForDelete) => {
    try {
        const {data} = await axios.delete(`/api/permissions/${permissionForDelete.id}`)
        permissions.value = permissions.value.filter((permission) => permission.id !== permissionForDelete.id)
        closeModal('delete')
        toast.success(data.message)
    } catch (error) {
        console.error("Error deleting permission:", error)
        const errorMessage = error.response?.error || 'Error deleting permission';
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
            Add Permission
        </v-btn>

        <v-card elevation="5">
            <v-data-table-server
                v-model:items-per-page="itemsPerPage"
                :headers="headers"
                :items="permissions"
                :items-length="totalItems"
                :loading="isLoading"
                @update:options="loadPermissions"
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
                @save="addPermission"
                @close="closeModal('add')"
            />
        </v-dialog>

        <v-dialog v-model="modals.update" max-width="500px">
            <UpdateForm
                v-if="selectedPermission"
                :title="'Update Permission'"
                :entity="selectedPermission"
                :fields="[
                    { model: 'name', label: 'Name', type: 'text' },
                    { model: 'guard_name', label: 'Guard', type: 'text' },
                ]"
                @save="updatePermission"
                @close="closeModal('update')"
            />
        </v-dialog>

        <v-dialog v-model="modals.delete" max-width="500px">
            <DeleteForm
                v-if="selectedPermission"
                :title="'Delete Permission'"
                :entity="selectedPermission"
                :entityTitleKey="'name'"
                :message="'Are you sure you want to delete the permission:'"
                @delete="deletePermission"
                @close="closeModal('delete')"
            />
        </v-dialog>
    </v-container>
</template>

