<template>
  <a-form
    :ref="formRef"
    :name="name"
    :model="model"
    :rules="rules"
    @finish="handleFinish"
  >
    <slot></slot>
    <a-form-item :wrapper-col="{ span: 14, offset: 2 }">
      <a-button v-if="!hideSend" type="primary" html-type="submit"
        >Enviar</a-button
      >
      <a-button v-if="!hideReset" style="margin-left: 10px" @click="resetForm"
        >Limpar</a-button
      >
    </a-form-item>
  </a-form>
</template>
<script>
export default {
  props: {
    formRef: {
      type: String,
      default: "formRef",
    },
    name: {
      type: String,
      default: "",
    },
    model: {
      type: Object,
    },
    rules: {
      type: Object,
    },
    hideSend: {
      type: Boolean,
      default: false,
    },
    hideReset: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    resetForm: function () {
      this.$refs[this.formRef].resetFields();
    },
    handleFinish(values) {
      this.$emit("send", values);
    },
  },
};
</script>