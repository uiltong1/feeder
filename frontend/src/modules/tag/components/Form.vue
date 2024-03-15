<template>
    <div>
        <a-form :model="formState" name="basic" :label-col="{ span: 8 }" :wrapper-col="{ span: 16 }" autocomplete="off"
            @finish="onFinish">
            <a-form-item label="ID" name="id" hidden>
                <a-input v-model:value="formState.id" readonly />
            </a-form-item>
            <a-form-item label="Tag" name="slug" :rules="[{ required: true, message: 'Por favor informe o nome da tag!' }]">
                <a-input v-model:value="formState.slug" :readonly="isDisable" />
            </a-form-item>
            <a-form-item v-if="!isDisable" :wrapper-col="{ offset: 8, span: 16 }">
                <a-button type="primary" html-type="submit" :loading="loading">Salvar</a-button>
            </a-form-item>
        </a-form>
    </div>
</template>
<script>
export default {
    name: "FormTag",
    data() {
        return {
            open: false,
            formState: {
                id: null,
                slug: "",
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
            slug: this.item.slug,
        }
    },
    methods: {
        onFinish(values) {
            this.$emit('send', values)
        },
    }
}
</script>