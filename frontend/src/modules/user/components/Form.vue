<template>
    <div>
        <a-form :model="formState" name="basic" :label-col="{ span: 8 }" :wrapper-col="{ span: 16 }" autocomplete="off"
            @finish="onFinish">
            <a-form-item label="ID" name="id" hidden>
                <a-input v-model:value="formState.id" readonly />
            </a-form-item>
            <a-form-item label="Nome" name="name" :rules="[{ required: true, message: 'Por favor informe o nome!' }]">
                <a-input v-model:value="formState.name" :readonly="isDisable" />
            </a-form-item>

            <a-form-item label="E-mail" name="email" :rules="[{ required: true, message: 'Por favor informe o e-mail!' },
            { type: 'email', message: 'Insira um e-mail válido!' }]">
                <a-input v-model:value="formState.email" :readonly="isDisable" />
            </a-form-item>
            <a-form-item v-if="!isDisable" :wrapper-col="{ offset: 8, span: 16 }">
                <a-button type="primary" html-type="submit" :loading="loading">Salvar</a-button>
            </a-form-item>
        </a-form>
    </div>
</template>
<script>
export default {
    name: "FormUser",
    data() {
        return {
            open: false,
            formState: {
                id: null,
                name: "",
                email: ""
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
        }
    },
    mounted() {
        this.formState = {
            id: this.item.id ?? null,
            name: this.item.name,
            email: this.item.email
        }
    },
    methods: {
        onFinish(values) {
            this.$emit('send', values)
        },
    }
}
</script>