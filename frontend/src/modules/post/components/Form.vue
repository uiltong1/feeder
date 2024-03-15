<template>
    <div>
        <a-form :model="formState" name="basic" :label-col="{ span: 8 }" :wrapper-col="{ span: 16 }" autocomplete="off"
            @finish="onFinish">
            <a-form-item label="ID" name="id" hidden>
                <a-input v-model:value="formState.id" readonly />
            </a-form-item>
            <a-form-item label="Titulo" name="title" :rules="[{ required: true, message: 'Por favor informe o titulo!' }]">
                <a-input v-model:value="formState.title" :readonly="isDisable" />
            </a-form-item>

            <a-form-item label="Usuário" name="user_id"
                :rules="[{ required: true, message: 'Por favor selecione o usuário!' }]">
                <a-select v-model:value="formState.user_id" style="width: 200px" :options="users"
                    :fieldNames="{ label: 'name', value: 'id' }" :disabled="isDisable"></a-select>
            </a-form-item>

            <a-form-item label="Tags" name="tags" :rules="[{ required: true, message: 'Por favor selecione uma ou mais tags!' }]">
                <a-select mode="multiple" v-model:value="formState.tags" style="width: 200px" :options="tags"
                    :fieldNames="{ label: 'slug', value: 'id' }" :disabled="isDisable"></a-select>
            </a-form-item>

            <a-form-item label="Texto" name="body" :rules="[{ required: true, message: 'Por favor informe o texto!' }]">
                <a-textarea v-model:value="formState.body" :readonly="isDisable" />
            </a-form-item>

            <a-form-item v-if="!isDisable" :wrapper-col="{ offset: 8, span: 16 }">
                <a-button type="primary" html-type="submit" :loading="loading">Salvar</a-button>
            </a-form-item>
        </a-form>
    </div>
</template>
<script>
export default {
    name: "FormPost",
    data() {
        return {
            open: false,
            formState: {
                id: null,
                title: "",
                body: "",
                user_id: "",
                tags: []
            }
        }
    },
    props: {
        loading: {
            type: Boolean,
            default: false
        },
        item: {
            type: Object
        },
        isDisable: {
            type: Boolean,
            default: false
        },
        users: {
            type: Array,
            default: () => []
        },
        tags: {
            type: Array,
            default: () => []
        }
    },
    mounted() {
        if(this.item){
            this.formState = {
                id: this.item.id ?? null,
                title: this.item.title,
                body: this.item.body,
                user_id: this.item.user_id,
                tags: this.item?.tags?.map(element => element?.id)
            }
        }
    },
    methods: {
        onFinish(values) {
            this.$emit('send', values)
        },
    }
}
</script>